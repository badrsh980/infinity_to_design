<?php

use App\Models\Option;
use Illuminate\Support\Str;

function getOption($name, $default = null)
{
    $option = Option::where('name', $name)->first();

    if ($option)
        return $option->content;

    return $default;
}

function price_format($price)
{
    return number_format($price, 2) . getOption('currency_code', '$');
}

function isJson($data)
{
    if (!empty($data)) {
        return is_string($data) &&
            is_array(json_decode($data, true)) ? true : false;
    }
    return false;
}

function user()
{
    if (auth()->check()) {
        return auth()->user();
    }

    return null;
}

function to_pennies($value)
{
    return intval(
        strval(floatval(
            preg_replace("/[^0-9.]/", "", $value)
        ) * 100)
    );
}

function array_of_times()
{
    $days = [];
    $days[1] = __('One Day');
    $days[2] = __('Two Days');
    $days[3] = __('Three Days');
    $days[4] = __('Four Days');
    $days[5] = __('Five Days');
    $days[6] = __('Six Days');
    $days[7] = __('One Week');
    $days[8] = __('Two Weeks');
    $days[9] = __('Three Weeks');
    $days[10] = __('One Month');

    return $days;
}

function array_of_extras_prices()
{
    $prices = [];
    $i = 5;

    while ($i <= 100) {
        $prices[$i] = __('For an additional $:dollars on the price of the service', [
            'dollars' => $i
        ]);
        $i += 5;
    }

    return $prices;
}

function unique_str()
{
    return str()->lower(str()->ulid()) .  '-';
}

function get_countries()
{
    $countries = [
        '' => __("Select Country"),
        "AF" => __("messages.countries.AF"),
        "AL" => __("messages.countries.AL"),
        "DZ" => __("messages.countries.DZ"),
        "AS" => __("messages.countries.AS"),
        "AD" => __("messages.countries.AD"),
        "AO" => __("messages.countries.AO"),
        "AI" => __("messages.countries.AI"),
        "AQ" => __("messages.countries.AQ"),
        "AG" => __("messages.countries.AG"),
        "AR" => __("messages.countries.AR"),
        "AM" => __("messages.countries.AM"),
        "AW" => __("messages.countries.AW"),
        "AU" => __("messages.countries.AU"),
        "AT" => __("messages.countries.AT"),
        "AX" => __("messages.countries.AX"),
        "AZ" => __("messages.countries.AZ"),
        "BS" => __("messages.countries.BS"),
        "BH" => __("messages.countries.BH"),
        "BD" => __("messages.countries.BD"),
        "BB" => __("messages.countries.BB"),
        "BY" => __("messages.countries.BY"),
        "BE" => __("messages.countries.BE"),
        "BZ" => __("messages.countries.BZ"),
        "BJ" => __("messages.countries.BJ"),
        "BM" => __("messages.countries.BM"),
        "BT" => __("messages.countries.BT"),
        "BO" => __("messages.countries.BO"),
        "BA" => __("messages.countries.BA"),
        "BW" => __("messages.countries.BW"),
        "BV" => __("messages.countries.BV"),
        "BR" => __("messages.countries.BR"),
        "IO" => __("messages.countries.IO"),
        "BN" => __("messages.countries.BN"),
        "BG" => __("messages.countries.BG"),
        "BF" => __("messages.countries.BF"),
        "BI" => __("messages.countries.BI"),
        "KH" => __("messages.countries.KH"),
        "CM" => __("messages.countries.CM"),
        "CA" => __("messages.countries.CA"),
        "CV" => __("messages.countries.CV"),
        "KY" => __("messages.countries.KY"),
        "CF" => __("messages.countries.CF"),
        "TD" => __("messages.countries.TD"),
        "CL" => __("messages.countries.CL"),
        "CN" => __("messages.countries.CN"),
        "CX" => __("messages.countries.CX"),
        "CC" => __("messages.countries.CC"),
        "CO" => __("messages.countries.CO"),
        "KM" => __("messages.countries.KM"),
        "CG" => __("messages.countries.CG"),
        "CD" => __("messages.countries.CD"),
        "CK" => __("messages.countries.CK"),
        "CR" => __("messages.countries.CR"),
        "CI" => __("messages.countries.CI"),
        "CW" => __("messages.countries.CW"),
        "HR" => __("messages.countries.HR"),
        "CU" => __("messages.countries.CU"),
        "CY" => __("messages.countries.CY"),
        "CZ" => __("messages.countries.CZ"),
        "DK" => __("messages.countries.DK"),
        "DJ" => __("messages.countries.DJ"),
        "DM" => __("messages.countries.DM"),
        "DO" => __("messages.countries.DO"),
        "TP" => __("messages.countries.TP"),
        "EC" => __("messages.countries.EC"),
        "EG" => __("messages.countries.EG"),
        "SV" => __("messages.countries.SV"),
        "GQ" => __("messages.countries.GQ"),
        "ER" => __("messages.countries.ER"),
        "EE" => __("messages.countries.EE"),
        "ET" => __("messages.countries.ET"),
        "FK" => __("messages.countries.FK"),
        "FO" => __("messages.countries.FO"),
        "FJ" => __("messages.countries.FJ"),
        "FI" => __("messages.countries.FI"),
        "FR" => __("messages.countries.FR"),
        "FX" => __("messages.countries.FX"),
        "GF" => __("messages.countries.GF"),
        "PF" => __("messages.countries.PF"),
        "TF" => __("messages.countries.TF"),
        "GA" => __("messages.countries.GA"),
        "GM" => __("messages.countries.GM"),
        "GE" => __("messages.countries.GE"),
        "DE" => __("messages.countries.DE"),
        "GH" => __("messages.countries.GH"),
        "GI" => __("messages.countries.GI"),
        "GR" => __("messages.countries.GR"),
        "GL" => __("messages.countries.GL"),
        "GD" => __("messages.countries.GD"),
        "GP" => __("messages.countries.GP"),
        "GU" => __("messages.countries.GU"),
        "GT" => __("messages.countries.GT"),
        "GN" => __("messages.countries.GN"),
        "GW" => __("messages.countries.GW"),
        "GY" => __("messages.countries.GY"),
        "HT" => __("messages.countries.HT"),
        "HM" => __("messages.countries.HM"),
        "VA" => __("messages.countries.VA"),
        "HN" => __("messages.countries.HN"),
        "HK" => __("messages.countries.HK"),
        "HU" => __("messages.countries.HU"),
        "IS" => __("messages.countries.IS"),
        "IM" => __("messages.countries.IM"),
        "IN" => __("messages.countries.IN"),
        "ID" => __("messages.countries.ID"),
        "IR" => __("messages.countries.IR"),
        "IQ" => __("messages.countries.IQ"),
        "IE" => __("messages.countries.IE"),
        // "IL" => __("messages.countries.IL"),
        "IT" => __("messages.countries.IT"),
        "JE" => __("messages.countries.JE"),
        "JM" => __("messages.countries.JM"),
        "JP" => __("messages.countries.JP"),
        "JO" => __("messages.countries.JO"),
        "KZ" => __("messages.countries.KZ"),
        "KE" => __("messages.countries.KE"),
        "KI" => __("messages.countries.KI"),
        "KP" => __("messages.countries.KP"),
        "KR" => __("messages.countries.KR"),
        "XK" => __("messages.countries.XK"),
        "KW" => __("messages.countries.KW"),
        "KG" => __("messages.countries.KG"),
        "LA" => __("messages.countries.LA"),
        "LV" => __("messages.countries.LV"),
        "LB" => __("messages.countries.LB"),
        "LS" => __("messages.countries.LS"),
        "LR" => __("messages.countries.LR"),
        "LY" => __("messages.countries.LY"),
        "LI" => __("messages.countries.LI"),
        "LT" => __("messages.countries.LT"),
        "LU" => __("messages.countries.LU"),
        "MO" => __("messages.countries.MO"),
        "MK" => __("messages.countries.MK"),
        "MG" => __("messages.countries.MG"),
        "MW" => __("messages.countries.MW"),
        "MY" => __("messages.countries.MY"),
        "MV" => __("messages.countries.MV"),
        "ML" => __("messages.countries.ML"),
        "MT" => __("messages.countries.MT"),
        "MH" => __("messages.countries.MH"),
        "MQ" => __("messages.countries.MQ"),
        "MR" => __("messages.countries.MR"),
        "MU" => __("messages.countries.MU"),
        "YT" => __("messages.countries.YT"),
        "MX" => __("messages.countries.MX"),
        "FM" => __("messages.countries.FM"),
        "MD" => __("messages.countries.MD"),
        "MC" => __("messages.countries.MC"),
        "ME" => __("messages.countries.ME"),
        "MN" => __("messages.countries.MN"),
        "MS" => __("messages.countries.MS"),
        "MA" => __("messages.countries.MA"),
        "MZ" => __("messages.countries.MZ"),
        "MM" => __("messages.countries.MM"),
        "NA" => __("messages.countries.NA"),
        "NR" => __("messages.countries.NR"),
        "NP" => __("messages.countries.NP"),
        "NL" => __("messages.countries.NL"),
        "AN" => __("messages.countries.AN"),
        "NC" => __("messages.countries.NC"),
        "NZ" => __("messages.countries.NZ"),
        "NI" => __("messages.countries.NI"),
        "NE" => __("messages.countries.NE"),
        "NG" => __("messages.countries.NG"),
        "NU" => __("messages.countries.NU"),
        "NF" => __("messages.countries.NF"),
        "MP" => __("messages.countries.MP"),
        "NO" => __("messages.countries.NO"),
        "OM" => __("messages.countries.OM"),
        "PK" => __("messages.countries.PK"),
        "PW" => __("messages.countries.PW"),
        "PA" => __("messages.countries.PA"),
        "PG" => __("messages.countries.PG"),
        "PY" => __("messages.countries.PY"),
        "PE" => __("messages.countries.PE"),
        "PH" => __("messages.countries.PH"),
        "PN" => __("messages.countries.PN"),
        "PL" => __("messages.countries.PL"),
        "PT" => __("messages.countries.PT"),
        "PR" => __("messages.countries.PR"),
        "PS" => __("messages.countries.PS"),
        "QA" => __("messages.countries.QA"),
        "RE" => __("messages.countries.RE"),
        "RO" => __("messages.countries.RO"),
        "RS" => __("messages.countries.RS"),
        "RU" => __("messages.countries.RU"),
        "RW" => __("messages.countries.RW"),
        "KN" => __("messages.countries.KN"),
        "LC" => __("messages.countries.LC"),
        "VC" => __("messages.countries.VC"),
        "WS" => __("messages.countries.WS"),
        "SM" => __("messages.countries.SM"),
        "ST" => __("messages.countries.ST"),
        "SA" => __("messages.countries.SA"),
        "SN" => __("messages.countries.SN"),
        "SC" => __("messages.countries.SC"),
        "SL" => __("messages.countries.SL"),
        "SG" => __("messages.countries.SG"),
        "SK" => __("messages.countries.SK"),
        "SI" => __("messages.countries.SI"),
        "SB" => __("messages.countries.SB"),
        "SO" => __("messages.countries.SO"),
        "SX" => __("messages.countries.SX"),
        "ZA" => __("messages.countries.ZA"),
        "GS" => __("messages.countries.GS"),
        "ES" => __("messages.countries.ES"),
        "LK" => __("messages.countries.LK"),
        "SH" => __("messages.countries.SH"),
        "PM" => __("messages.countries.PM"),
        "SD" => __("messages.countries.SD"),
        "SR" => __("messages.countries.SR"),
        "SJ" => __("messages.countries.SJ"),
        "SZ" => __("messages.countries.SZ"),
        "SE" => __("messages.countries.SE"),
        "CH" => __("messages.countries.CH"),
        "SY" => __("messages.countries.SY"),
        "TW" => __("messages.countries.TW"),
        "TJ" => __("messages.countries.TJ"),
        "TZ" => __("messages.countries.TZ"),
        "TH" => __("messages.countries.TH"),
        "TG" => __("messages.countries.TG"),
        "TK" => __("messages.countries.TK"),
        "TO" => __("messages.countries.TO"),
        "TT" => __("messages.countries.TT"),
        "TN" => __("messages.countries.TN"),
        "TR" => __("messages.countries.TR"),
        "TM" => __("messages.countries.TM"),
        "TC" => __("messages.countries.TC"),
        "TV" => __("messages.countries.TV"),
        "UG" => __("messages.countries.UG"),
        "UA" => __("messages.countries.UA"),
        "AE" => __("messages.countries.AE"),
        "GB" => __("messages.countries.GB"),
        "US" => __("messages.countries.US"),
        "UM" => __("messages.countries.UM"),
        "UY" => __("messages.countries.UY"),
        "UZ" => __("messages.countries.UZ"),
        "VU" => __("messages.countries.VU"),
        "VE" => __("messages.countries.VE"),
        "VN" => __("messages.countries.VN"),
        "VG" => __("messages.countries.VG"),
        "VI" => __("messages.countries.VI"),
        "WF" => __("messages.countries.WF"),
        // "EH" => __("messages.countries.EH"),
        "YE" => __("messages.countries.YE"),
        "YU" => __("messages.countries.YU"),
        "ZM" => __("messages.countries.ZM"),
        "ZW" => __("messages.countries.ZW"),
        "AX" => __("messages.countries.AX"),
        "XK" => __("messages.countries.XK"),
        "WF" => __("messages.countries.WF"),
        "GB" => __("messages.countries.GB"),
        "TL" => __("messages.countries.TL"),
        "SS" => __("messages.countries.SS"),
        "BL" => __("messages.countries.BL"),
        "MF" => __("messages.countries.MF"),
    ];

    return $countries;
}
