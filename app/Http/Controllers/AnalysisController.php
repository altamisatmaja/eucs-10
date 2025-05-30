<?php

namespace App\Http\Controllers;

use App\Models\RecordValue;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AnalysisController extends Controller
{
    const MAX_SCALE = 4;
    const EUCS_DIMENSIONS = [
        'Content' => ['x11', 'x12', 'x13', 'x14', 'x15'],
        'Accuracy' => ['x21', 'x22', 'x23', 'x24', 'x25'],
        'Format' => ['x31', 'x32', 'x33', 'x34', 'x35'],
        'Ease of Use' => ['x41', 'x42', 'x43', 'x44', 'x45'],
        'Timeliness' => ['x51', 'x52', 'x53', 'x54', 'x55'],
        'User Satisfaction' => ['y1', 'y2', 'y3', 'y4', 'y5']
    ];

    const ACHIEVEMENT_LEVELS = [
        ['min' => 75.01, 'max' => 100, 'label' => 'Sangat Tinggi'],
        ['min' => 58.34, 'max' => 75.01, 'label' => 'Tinggi'],
        ['min' => 41.66, 'max' => 58.34, 'label' => 'Kurang'],
        ['min' => 24.99, 'max' => 41.66, 'label' => 'Rendah'],
        ['min' => 0, 'max' => 24.99, 'label' => 'Sangat Rendah'],
    ];

    /**
     * Display EUCS analysis results
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $this->validateRequest($request);
            $reference = (int) $request->query('references');

            $groupedData = $this->getGroupedEUCSData($reference);

            if ($this->isEmptyData($groupedData)) {
                return $this->renderErrorView(
                    $reference,
                    'Tidak ditemukan data dengan reference ID ' . $reference . '. Silakan periksa kembali.'
                );
            }

            $results = [
                'statistics' => $this->calculateEucsStats($groupedData),
                'achievement' => $this->calculateAchievement($groupedData)
            ];

            return view('analysis.index', [
                'results' => $results,
                'reference' => $reference,
                'dataExists' => true
            ]);
        } catch (ValidationException $e) {
            return $this->renderErrorView(null, $e->getMessage());
        } catch (\Exception $e) {
            Log::error('AnalysisController error: ' . $e->getMessage());
            return $this->renderErrorView(
                $request->query('references'),
                'Terjadi kesalahan saat memproses data. Silakan coba lagi.'
            );
        }
    }

    /**
     * Validate the request parameters
     *
     * @param Request $request
     * @throws ValidationException
     */
    protected function validateRequest(Request $request): void
    {
        $request->validate([
            'references' => 'required|integer|min:1'
        ], [
            'references.required' => 'Parameter reference ID diperlukan',
            'references.integer' => 'Format reference ID tidak valid',
            'references.min' => 'Reference ID harus bernilai positif'
        ]);
    }

    /**
     * Render error view with message
     *
     * @param int|null $reference
     * @param string $message
     * @return \Illuminate\View\View
     */
    protected function renderErrorView(?int $reference, string $message)
    {
        return view('analysis.index', [
            'results' => null,
            'reference' => $reference,
            'dataExists' => false,
            'errorMessage' => $message
        ]);
    }

    /**
     * Check if grouped data is empty
     *
     * @param Collection $groupedData
     * @return bool
     */
    protected function isEmptyData(Collection $groupedData): bool
    {
        return $groupedData->every(function ($values) {
            return $values->isEmpty();
        });
    }

    /**
     * Get EUCS data grouped by dimensions
     *
     * @param int $reference
     * @return Collection
     */
    protected function getGroupedEUCSData(int $reference): Collection
    {
        $data = RecordValue::where('record_id', $reference)
            ->whereNotNull('value')
            ->get();


        return collect(self::EUCS_DIMENSIONS)->mapWithKeys(function ($variables, $dimension) use ($data) {
            $filtered = $data->filter(function ($item) use ($variables) {
                return in_array(strtolower($item->variable), array_map('strtolower', $variables));
            });

            return [$dimension => $filtered];
        });
    }

    /**
     * Calculate statistics for each EUCS dimension
     *
     * @param Collection $groupedData
     * @return array
     */
    protected function calculateEucsStats(Collection $groupedData): array
    {
        return $groupedData->map(function ($values) {
            $numericValues = $values->pluck('value')->filter()->values()->toArray();
            $n = count($numericValues);

            if ($n === 0) {
                return $this->getEmptyStats();
            }

            $sum = array_sum($numericValues);
            $sumSquares = array_sum(array_map(fn($v) => $v ** 2, $numericValues));

            return [
                'n' => $n,
                'sum' => $sum,
                'mean' => $sum / $n,
                'variance' => $n > 1 ? ($sumSquares - ($sum ** 2 / $n)) / ($n - 1) : 0,
                'std_dev' => $n > 1 ? sqrt(($sumSquares - ($sum ** 2 / $n)) / ($n - 1)) : 0,
                'min' => min($numericValues),
                'max' => max($numericValues),
                'range' => max($numericValues) - min($numericValues)
            ];
        })->toArray();
    }

    /**
     * Get empty statistics array
     *
     * @return array
     */
    protected function getEmptyStats(): array
    {
        return [
            'n' => 0,
            'sum' => 0,
            'mean' => 0,
            'variance' => 0,
            'std_dev' => 0,
            'min' => 0,
            'max' => 0,
            'range' => 0
        ];
    }

    /**
     * Calculate achievement levels
     *
     * @param Collection $groupedData
     * @return array
     */
    protected function calculateAchievement(Collection $groupedData): array
    {
        return $groupedData->map(function ($values) {
            $numericValues = $values->pluck('value')->filter()->values()->toArray();
            $n = count($numericValues);

            if ($n === 0) {
                return [
                    'mean' => 0,
                    'achievement_percentage' => 0,
                    'interpretation' => 'Tidak Ada Data'
                ];
            }

            $mean = array_sum($numericValues) / $n;
            $achievementScore = ($mean / self::MAX_SCALE) * 100;

            return [
                'mean' => $mean,
                'achievement_percentage' => $achievementScore,
                'interpretation' => $this->interpretAchievement($achievementScore)
            ];
        })->toArray();
    }

    /**
     * Interpret achievement score
     *
     * @param float $percentage
     * @return string
     */
    protected function interpretAchievement(float $percentage): string
    {
        foreach (self::ACHIEVEMENT_LEVELS as $level) {
            if ($percentage > $level['min'] && $percentage <= $level['max']) {
                return $level['label'];
            }
        }

        return 'Tidak Diketahui';
    }
}
