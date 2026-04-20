<?php

namespace App\Services;

use App\Models\Sequence;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\UniqueConstraintViolationException;

class SequenceService
{
    /**
     * Get the next sequence number atomically.
     *
     * @param string|null $tenantId
     * @param string $type
     * @param string|null $categoryId
     * @param int $year
     * @return int
     */
    public function getNextValue(?string $tenantId, string $type, ?string $categoryId, int $year): int
    {
        try {
            return $this->incrementAndGet($tenantId, $type, $categoryId, $year);
        } catch (UniqueConstraintViolationException $e) {
            // If another process created it simultaneously, try again
            return $this->incrementAndGet($tenantId, $type, $categoryId, $year);
        }
    }

    protected function incrementAndGet(?string $tenantId, string $type, ?string $categoryId, int $year): int
    {
        return DB::transaction(function () use ($tenantId, $type, $categoryId, $year) {
            $sequence = Sequence::where('tenant_id', $tenantId)
                ->where('type', $type)
                ->where('category_id', $categoryId)
                ->where('year', $year)
                ->lockForUpdate()
                ->first();

            if (!$sequence) {
                $sequence = Sequence::create([
                    'tenant_id' => $tenantId,
                    'type' => $type,
                    'category_id' => $categoryId,
                    'year' => $year,
                    'last_value' => 0,
                ]);
            }

            $sequence->increment('last_value');

            return $sequence->last_value;
        });
    }
}
