<?php

namespace App\Entities\Enums;

enum OperationType: int
{
    case NOT_SELECTED = 0;
    case TYPE1 = 1;
    case TYPE2 = 2;
    case TYPE3 = 3;
    case TYPE4 = 4;
    case TYPE5 = 5;
    case TYPE6 = 6;
    case TYPE7 = 7;
    case TYPE8 = 8;
    case TYPE9 = 9;
    case TYPE10 = 10;
    case TYPE11 = 11;
    case TYPE12 = 12;
    case TYPE13 = 13;
    case TYPE14 = 14;
    case TYPE15 = 15;
    case TYPE16 = 16;
    case TYPE17 = 17;
    case TYPE18 = 18;
    case TYPE19 = 19;
    case TYPE20 = 20;

    public static function getLabel(int $enum): string
    {
        return match ($enum) {
            self::NOT_SELECTED->value => 'Не выбрано',
            self::TYPE1->value => 'Рег А+Т+С',
            self::TYPE2->value => 'Рега АБ',
            self::TYPE3->value => 'Рега СБ',
            self::TYPE4->value => 'Рега ТН',
            self::TYPE5->value => 'РКО АБ',
            self::TYPE6->value => 'РКО ТН',
            self::TYPE7->value => 'РКО СБ',
            self::TYPE8->value => 'РКО А+Т+С',
            self::TYPE9->value => 'РКО А+Т',
            self::TYPE10->value => 'РКО А+С',
            self::TYPE11->value => 'РКО Т+С',
            self::TYPE12->value => 'Рега А+С',
            self::TYPE13->value => 'Рега А+Т',
            self::TYPE14->value => 'Рега Т+С',
            self::TYPE15->value => 'РКО ПСБ',
            self::TYPE16->value => 'РКО А+П',
            self::TYPE17->value => 'РКО С+П',
            self::TYPE18->value => 'РКО Т+П',
            self::TYPE19->value => 'РКО С+Т+П',
            self::TYPE20->value => 'РКО А+Т+П',
            default => ''
        };
    }
}