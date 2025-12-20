<?php
/**
 * Water quality parameters
 * @author    Jatniel Guzmán https://jatniel.dev
 * @copyright    2025
 * @license    MIT
 */

declare(strict_types=1);

namespace App\Enums;

/**
 * Water quality parameters based on Hub'Eau API codes
 */
enum WaterParameter: string
{
    case NITRATES = '1340';
    case NITRITES = '1345';
    case DURETE = '1347';
    case PH = '1338';
    case ECOLI = '5504';
    case CHLORE_LIBRE = '1310';

    /**
     * Get parameter label in French
     */
    public function label(): string
    {
        return match ($this) {
            self::NITRATES => 'Nitrates',
            self::NITRITES => 'Nitrites',
            self::DURETE => 'Dureté',
            self::PH => 'pH',
            self::ECOLI => 'E. coli',
            self::CHLORE_LIBRE => 'Chlore libre',
        };
    }

    /**
     * Get measurement unit
     */
    public function unit(): string
    {
        return match ($this) {
            self::NITRATES => 'mg/L',
            self::NITRITES => 'mg/L',
            self::DURETE => '°f',
            self::PH => '',
            self::ECOLI => 'UFC/100mL',
            self::CHLORE_LIBRE => 'mg/L',
        };
    }

    /**
     * Get WHO/EU limit value
     */
    public function limit(): ?float
    {
        return match ($this) {
            self::NITRATES => 50.0,
            self::NITRITES => 0.5,
            self::DURETE => null, // No legal limit
            self::PH => null, // Range based (6.5-9.0)
            self::ECOLI => 0.0,
            self::CHLORE_LIBRE => 5.0,
        };
    }

    /**
     * Get parameter description
     */
    public function description(): string
    {
        return match ($this) {
            self::NITRATES => 'Indicateur de pollution agricole ou organique',
            self::NITRITES => 'Produit intermédiaire de l\'oxydation de l\'azote',
            self::DURETE => 'Concentration en calcium et magnésium',
            self::PH => 'Mesure de l\'acidité ou de l\'alcalinité',
            self::ECOLI => 'Bactérie indicatrice de contamination fécale',
            self::CHLORE_LIBRE => 'Désinfectant résiduel',
        };
    }

    /**
     * Evaluate water quality based on parameter value
     */
    public function evaluate(float $value): WaterQualityStatus
    {
        return match ($this) {
            self::NITRATES => match (true) {
                $value <= 25.0 => WaterQualityStatus::EXCELLENT,
                $value <= 40.0 => WaterQualityStatus::GOOD,
                $value <= 50.0 => WaterQualityStatus::ACCEPTABLE,
                default => WaterQualityStatus::CRITICAL,
            },
            self::NITRITES => match (true) {
                $value <= 0.1 => WaterQualityStatus::EXCELLENT,
                $value <= 0.3 => WaterQualityStatus::GOOD,
                $value <= 0.5 => WaterQualityStatus::ACCEPTABLE,
                default => WaterQualityStatus::CRITICAL,
            },
            self::DURETE => match (true) {
                $value <= 8.0 => WaterQualityStatus::SOFT,
                $value <= 20.0 => WaterQualityStatus::GOOD,
                $value <= 30.0 => WaterQualityStatus::ACCEPTABLE,
                default => WaterQualityStatus::HARD,
            },
            self::PH => match (true) {
                $value >= 6.5 && $value <= 8.5 => WaterQualityStatus::EXCELLENT,
                $value >= 6.0 && $value <= 9.0 => WaterQualityStatus::GOOD,
                default => WaterQualityStatus::CRITICAL,
            },
            self::ECOLI => match (true) {
                $value == 0.0 => WaterQualityStatus::EXCELLENT,
                $value <= 1.0 => WaterQualityStatus::ACCEPTABLE,
                default => WaterQualityStatus::CRITICAL,
            },
            self::CHLORE_LIBRE => match (true) {
                $value >= 0.2 && $value <= 0.5 => WaterQualityStatus::EXCELLENT,
                $value > 0.5 && $value <= 2.0 => WaterQualityStatus::GOOD,
                $value > 2.0 && $value <= 5.0 => WaterQualityStatus::ACCEPTABLE,
                default => WaterQualityStatus::CRITICAL,
            },
        };
    }

    /**
     * Get main parameters to display
     */
    public static function mainParameters(): array
    {
        return [
            self::NITRATES,
            self::NITRITES,
            self::DURETE,
            self::PH,
            self::ECOLI,
            self::CHLORE_LIBRE,
        ];
    }

    /**
     * Find parameter by Hub'Eau code
     */
    public static function fromCode(string $code): ?self
    {
        foreach (self::cases() as $parameter) {
            if ($parameter->value === $code) {
                return $parameter;
            }
        }

        return null;
    }
}
