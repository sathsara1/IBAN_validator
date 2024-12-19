<?php

namespace App\Enums;

enum IbanCountryLength
{
    case AL;
    case AD;
    case AT;
    case AZ;
    case BH;
    case BE;
    case BA;
    case BG;
    case HR;
    case CY;
    case CZ;
    case DK;
    case DO;
    case EE;
    case FI;
    case FR;
    case GE;
    case DE;
    case GR;
    case GL;
    case GT;
    case HU;
    case IS;
    case IE;
    case IL;
    case IT;
    case KZ;
    case KW;
    case LV;
    case LB;
    case LI;
    case LT;
    case LU;
    case MT;
    case MR;
    case MU;
    case MD;
    case MC;
    case ME;
    case NL;
    case NO;
    case PK;
    case PL;
    case PT;
    case QA;
    case RO;
    case SM;
    case SA;
    case RS;
    case SK;
    case SI;
    case ES;
    case SD;
    case SE;
    case CH;
    case TN;
    case TR;
    case AE;
    case GB;
    case VG;

    /**
     * Get the length of the IBAN for a specific country code.
     *
     * @return int|null
     */
    public function getLength(): ?int
    {
        $lengths = [
            self::AL->name => 28, self::AD->name => 24, self::AT->name => 20, self::AZ->name => 28, self::BH->name => 22,
            self::BE->name => 16, self::BA->name => 20, self::BG->name => 22, self::HR->name => 21, self::CY->name => 28,
            self::CZ->name => 24, self::DK->name => 18, self::DO->name => 28, self::EE->name => 20, self::FI->name => 18,
            self::FR->name => 27, self::GE->name => 22, self::DE->name => 22, self::GR->name => 27, self::GL->name => 18,
            self::GT->name => 28, self::HU->name => 28, self::IS->name => 26, self::IE->name => 22, self::IL->name => 23,
            self::IT->name => 27, self::KZ->name => 20, self::KW->name => 30, self::LV->name => 21, self::LB->name => 28,
            self::LI->name => 21, self::LT->name => 20, self::LU->name => 20, self::MT->name => 31, self::MR->name => 27,
            self::MU->name => 30, self::MD->name => 24, self::MC->name => 27, self::ME->name => 22, self::NL->name => 18,
            self::NO->name => 15, self::PK->name => 24, self::PL->name => 28, self::PT->name => 25, self::QA->name => 29,
            self::RO->name => 24, self::SM->name => 27, self::SA->name => 24, self::RS->name => 22, self::SK->name => 24,
            self::SI->name => 19, self::ES->name => 24, self::SD->name => 18, self::SE->name => 24, self::CH->name => 21,
            self::TN->name => 24, self::TR->name => 26, self::AE->name => 23, self::GB->name => 22, self::VG->name => 24
        ];

        return $lengths[$this->name] ?? null;
    }
}
