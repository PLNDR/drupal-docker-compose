<?php

namespace Drupal\naptar\Controller;
use Drupal\Core\Controller\ControllerBase;

/**
 * Controller for the calendar.
 */
class NaptarController extends ControllerBase {

    private $naptar;
    private $esemeny_adatok;
    private $esemeny_iterator;
    private $ma;
    private $base_path;

    private $het_napjai = ['hétfő', 'kedd', 'szerda', 'csütörtök', 'péntek', 'szombat', 'vasárnap'];
    private $honapok = ['január', 'február', 'március', 'április', 'május', 'június', 'július', 'augusztus', 'szeptember', 'október', 'november', 'december'];


    /**
     * Displays calendar page.
     * 
     * @var $ido
     *  The date, which should be visible in the calendar on the current view.
     * @var $mod
     *  Display mode of the calendar ('h': month view, 'e': week view, 'n': 'day view').
     */
    public function page($ido, $mod) {
        $this->esemeny_iterator = 0;
        $this->base_path = \Drupal\Core\Url::fromRoute('<front>', [], ['absolute' => TRUE])->toString();
        $this->ma = date("Y-m-d");

        // lekérjük az összes Eseményt
        $esemenyek = \Drupal::entityTypeManager()->getStorage('node')
            ->loadByProperties([
                'type' => 'esemeny',
                'status' => 1
            ]);
        
        // idozona problema megoldasa: az adatbazisban UTC-ben van mentve, vissza kell alakitani
        $userTimezone = new \DateTimeZone(date_default_timezone_get());
        $gmtTimezone = new \DateTimeZone('GMT');

        $this->esemeny_adatok = array();
        foreach ($esemenyek as $esemeny) {
            $myDateTime = new \DateTime($esemeny->get('field_kezdeti_idopont')->value, $gmtTimezone);
            $offset = $userTimezone->getOffset($myDateTime);
            $myInterval = \DateInterval::createFromDateString((string)$offset . 'seconds');
            $myDateTime->add($myInterval);
            $result = $myDateTime->format('Y-m-d H:i:s');

            array_push($this->esemeny_adatok, 
                array(
                    'kezdeti_idopont' => $result,
                    'kezdeti_idopont_timestamp' => strtotime($result),
                    'cim' => $esemeny->get('title')->value,
                    'id' => $esemeny->get('nid')->value
                )
            );
        }
        usort($this->esemeny_adatok, function($a, $b) { return strtotime($a['kezdeti_idopont']) < strtotime($b['kezdeti_idopont']) ? -1 : 1; });
        
        // osszeallitjuk a naptar parametereit
        $most = strtotime($ido);
        if ($ido != 'now') {
            $this->naptar_letrehozas($mod, $most);
        }
        else {
            $ido = count($this->esemeny_adatok) > 0 ? $this->esemeny_adatok[0]['kezdeti_idopont_timestamp'] : strtotime('now');
            foreach ($this->esemeny_adatok as $esemeny) {
                $esemeny_datum = $esemeny['kezdeti_idopont_timestamp'];
                if ($esemeny_datum > $most && $esemeny_datum < $ido) {
                    $ido = $esemeny_datum;
                }
            }
    
            $this->naptar_letrehozas($mod, $ido);
        }

       return array(
            '#theme' => 'esemenyek',
            '#naptar' => $this->naptar
        );
    }

    /**
     * Gathers all data to be shown in the calendar.
     */
    private function naptar_letrehozas($mod, $most) {
        $this->naptar = array(
            'mod' => $mod,
            'ev' => date('Y', $most),
            'honap' => date('m', $most),
            'honap_kiirva' => date('M', $most),
            'nap' => date('d', $most),
            'cim' => '',
            'linkek' => array(),
            'hetek' => array()
        );

        // nap nezet
        if ($this->naptar['mod'] == 'n') {
            array_push($this->naptar['hetek'], array());
            array_push($this->naptar['hetek'][0], $this->nap_hozzaadas($this->naptar['ev'], $this->naptar['honap'], $this->naptar['nap'], $this->het_napjanak_sorszama_jelenlegi_honapban($this->naptar['nap']), 'aktualis'));
        }
        // het nezet
        else if ($this->naptar['mod'] == 'e') {
            array_push($this->naptar['hetek'], array());
            $het_napja = $this->het_napjanak_sorszama($most);
            for ($i = 1; $i <= 7; ++$i) {
                $nap_kulonbseg = $het_napja - $i;
                if ($nap_kulonbseg > 0) {
                    $nap = strtotime(date('Y-m-d', strtotime($this->naptar['ev'] . '-' . $this->naptar['honap'] . '-' . $this->naptar['nap'] . ' - ' . $nap_kulonbseg . ' days')));
                }
                else if ($nap_kulonbseg < 0) {
                    $nap = strtotime(date('Y-m-d', strtotime($this->naptar['ev'] . '-' . $this->naptar['honap'] . '-' . $this->naptar['nap'] . ' + ' . abs($nap_kulonbseg) . ' days')));
                }
                else {
                    $nap = $most;
                }
                array_push($this->naptar['hetek'][0], $this->nap_hozzaadas(date('Y', $nap), date('m', $nap), date('d', $nap), $i, 'aktualis'));
            }
        }
        // honap nezet
        else {
            // mult honapbeli napok hozzaadasa
            array_push($this->naptar['hetek'], array());
            $honap_elso_napja = $this->het_napjanak_sorszama_jelenlegi_honapban(1);
            if ($honap_elso_napja != 1) {
                for ($i = 1; $i < $honap_elso_napja; $i++) {
                    $elozo_nap = strtotime($this->naptar['ev'] . '-' . $this->naptar['honap'] . '-01 -' . ($honap_elso_napja - $i) . ' days');
                    array_push($this->naptar['hetek'][0], $this->nap_hozzaadas(date('Y', $elozo_nap), date('m', $elozo_nap), date('d', $elozo_nap), $i, 'mult'));
                }
            }

            // e honapbeli napok hozzaadasa
            $napok_szama = cal_days_in_month(CAL_GREGORIAN, $this->naptar['honap'], $this->naptar['ev']);
            // kipotolni az elso hetet
            $i = 1;
            for ($j = $honap_elso_napja; $j <= 7; $j++) {
                array_push($this->naptar['hetek'][count($this->naptar['hetek']) - 1], $this->nap_hozzaadas($this->naptar['ev'], $this->naptar['honap'], $i, $this->het_napjanak_sorszama_jelenlegi_honapban($i), 'aktualis'));
                $i++;
            }
            array_push($this->naptar['hetek'], array());
            // tovabbi napok hozzaadasa a honap vegeig
            for (; $i <= $napok_szama; $i++) {
                array_push($this->naptar['hetek'][count($this->naptar['hetek']) - 1], $this->nap_hozzaadas($this->naptar['ev'], $this->naptar['honap'], $i, $this->het_napjanak_sorszama_jelenlegi_honapban($i), 'aktualis'));
                if (count($this->naptar['hetek'][count($this->naptar['hetek']) - 1]) == 7) {
                    array_push($this->naptar['hetek'], array());
                }
            }

            // jovo honapbeli napok hozzaadasa
            if (count($this->naptar['hetek']) == 5) {
                $utolso_het_napjainak_szama = count($this->naptar['hetek'][4]);
                $eddigi_utolso_nap_str = $this->naptar['ev'] . '-' . $this->naptar['honap'] . '-' . $napok_szama;
                for ($i = $utolso_het_napjainak_szama + 1; $i <= 7; ++$i) {
                    $kovetkezo_nap = strtotime(date('Y-m-d', strtotime($eddigi_utolso_nap_str . ' + ' . ($i - $utolso_het_napjainak_szama) . ' days')));
                    array_push($this->naptar['hetek'][4], $this->nap_hozzaadas(date('Y', $kovetkezo_nap), date('m', $kovetkezo_nap), date('j', $kovetkezo_nap), $i, 'jovo'));
                }
                array_push($this->naptar['hetek'], array());
            }
            if (count($this->naptar['hetek']) == 6) {
                $utolso_het_napjainak_szama = count($this->naptar['hetek'][5]);
                if ($utolso_het_napjainak_szama != 0) {
                    $eddigi_utolso_nap_str = $this->naptar['ev'] . '-' . $this->naptar['honap'] . '-' . $napok_szama;
                }
                else {
                    $eddigi_utolso_nap_str = $this->naptar['hetek'][4][6]['ev'] . '-' . $this->naptar['hetek'][4][6]['honap'] . '-' . $this->naptar['hetek'][4][6]['nap'];
                }
                for ($i = $utolso_het_napjainak_szama + 1; $i <= 7; ++$i) {
                    $kovetkezo_nap = strtotime(date('Y-m-d', strtotime($eddigi_utolso_nap_str . ' + ' . ($i - $utolso_het_napjainak_szama) . ' days')));
                    array_push($this->naptar['hetek'][5], $this->nap_hozzaadas(date('Y', $kovetkezo_nap), date('m', $kovetkezo_nap), date('j', $kovetkezo_nap), $i, 'jovo'));
                }
            }
        }

        $this->naptar_cimenek_beallitasa($most);
        $this->naptar_linkek_beallitasa($most);
    }

    /**
     * Adds a day to the calendar data.
     */
    private function nap_hozzaadas($ev, $honap, $nap, $het_napja, $tipus) {
        if ($this->ma == $ev . '-' . $honap . '-' . ((int)$nap < 10 ? '0' . $nap : $nap)) {
            $tipus = 'ma';
        }
        $mai_nap = array(
            'ev' => $ev,
            'honap' => $honap,
            'honap_kiirva' => $this->honapok[$honap - 1],
            'nap' => $nap,
            'nap_link' => $this->base_path . '/naptar/' . $ev . '-' . $honap . '-' . $nap . '/n',
            'het_napja' => $het_napja,
            'het_napja_kiirva' => $this->het_napjai[$het_napja - 1],
            'tipus' => $tipus,
            'esemenyek' => array()
        );

        // elnavigalni a mai esemenyekig
        $tegnap_nap_vege = strtotime($ev . '-' . $honap . '-' . $nap . ' 23:59:59 -1 days');
        while ($this->esemeny_iterator < count($this->esemeny_adatok) && $this->esemeny_adatok[$this->esemeny_iterator]['kezdeti_idopont_timestamp'] < $tegnap_nap_vege) {
            $this->esemeny_iterator++;
        }
        
        // atnavigalni a mai esemenyeken
        $holnap_nap_eleje = strtotime($ev . '-' . $honap . '-' . $nap . ' 00:00:00 +1 days');
        while ($this->esemeny_iterator < count($this->esemeny_adatok) && $this->esemeny_adatok[$this->esemeny_iterator]['kezdeti_idopont_timestamp'] < $holnap_nap_eleje) {
            // eltarolni az esemenyt
            $ora = date('G', $this->esemeny_adatok[$this->esemeny_iterator]['kezdeti_idopont_timestamp']);
            if (!$mai_nap['esemenyek'][$ora]) {
                $mai_nap['esemenyek'][$ora] = array();
            }
            array_push($mai_nap['esemenyek'][$ora], array(
                'idopont' => date('G:i', $this->esemeny_adatok[$this->esemeny_iterator]['kezdeti_idopont_timestamp']),
                'cim' => $this->esemeny_adatok[$this->esemeny_iterator]['cim'],
                'link' => $this->base_path . '/node/' . $this->esemeny_adatok[$this->esemeny_iterator]['id']
            ));
            $this->esemeny_iterator++;
        }

        return $mai_nap;
    }

    /**
     * Returns the day of the week.
     */
    private function het_napjanak_sorszama($most) {
        $het_napjanak_sorszama = date('w', $most);
        return $het_napjanak_sorszama > 0 ? $het_napjanak_sorszama : 7;
    }

    /**
     * Returns the day of the week in the current month.
     */
    private function het_napjanak_sorszama_jelenlegi_honapban($nap) {
        return $this->het_napjanak_sorszama(strtotime($nap . ' ' . $this->naptar['honap_kiirva'] . ' ' . $this->naptar['ev']));
    }

    /**
     * Sets the calendar title.
     */
    private function naptar_cimenek_beallitasa($most) {
        switch ($this->naptar['mod']) {
            case 'n':
                $this->naptar['cim'] = $this->naptar['ev'] . '. ' . $this->honapok[$this->naptar['honap'] - 1] . ' ' . (int)$this->naptar['nap'];
                break;
            case 'e';
                $elso_nap = $this->naptar['hetek'][0][0];
                $utolso_nap = $this->naptar['hetek'][0][6];
                $this->naptar['cim'] = $elso_nap['ev'] . '. ' . $this->honapok[$elso_nap['honap'] - 1] . ' ' . (int)$elso_nap['nap'] . ' - ';
                if ($elso_nap['ev'] != $utolso_nap['ev']) {
                    $this->naptar['cim'] .= $utolso_nap['ev'] . '. ';
                }
                if ($elso_nap['honap'] != $utolso_nap['honap']) {
                    $this->naptar['cim'] .= $this->honapok[$utolso_nap['honap'] - 1] . ' ';
                }
                $this->naptar['cim'] .= (int)$utolso_nap['nap'];
                break;
            default:
                $this->naptar['cim'] = $this->naptar['ev'] . '. ' . $this->honapok[$this->naptar['honap'] - 1];
                break;
        }
    }

    /**
     * Sets the different view mode links.
     */
    private function naptar_linkek_beallitasa($most) {
        $datum_str = $this->naptar['ev'] . '-' . $this->naptar['honap'] . '-' . $this->naptar['nap'];

        $this->naptar['linkek']['nap'] = $this->base_path . '/naptar/' . $datum_str . '/n';
        $this->naptar['linkek']['het'] = $this->base_path . '/naptar/' . $datum_str . '/e';
        $this->naptar['linkek']['honap'] = $this->base_path . '/naptar/' . $datum_str . '/h';
        switch ($this->naptar['mod']) {
            case 'n':
                $this->naptar['linkek']['ma'] = $this->base_path . '/naptar/' . $this->ma . '/n';
                $this->naptar['linkek']['elozo'] = $this->base_path . '/naptar/' . date('Y-m-d', strtotime($datum_str . ' -1 days')) . '/n';
                $this->naptar['linkek']['kovetkezo'] = $this->base_path . '/naptar/' . date('Y-m-d', strtotime($datum_str . ' +1 days')) . '/n';
                break;
            case 'e':
                $this->naptar['linkek']['ma'] = $this->base_path . '/naptar/' . $this->ma . '/e';
                $this->naptar['linkek']['elozo'] = $this->base_path . '/naptar/' . date('Y-m-d', strtotime($datum_str . ' -7 days')) . '/e';
                $this->naptar['linkek']['kovetkezo'] = $this->base_path . '/naptar/' . date('Y-m-d', strtotime($datum_str . ' +7 days')) . '/e';
                break;
            default:
                $this->naptar['linkek']['ma'] = $this->base_path . '/naptar/' . $this->ma . '/h';
                $this->naptar['linkek']['elozo'] = $this->base_path . '/naptar/' . date('Y-m-d', strtotime($datum_str . ' -1 months')) . '/h';
                $this->naptar['linkek']['kovetkezo'] = $this->base_path . '/naptar/' . date('Y-m-d', strtotime($datum_str . ' +1 months')) . '/h';
                break;
        }
    }
}