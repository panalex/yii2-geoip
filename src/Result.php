<?php


namespace lysenkobv\GeoIP;

/**
 * Class Result
 * @package lysenkobv\GeoIP
 *
 * @property string|null $city
 * @property string|null $cityGeoname
 * @property string|null $subdivisionIso
 * @property string|null $subdivisionGeoname
 * @property string|null $country
 * @property string|null $countryGeoname
 * @property Location $location
 * @property string|null $countryIso
 */
class Result extends ResultBase {
    public $lang;

    public function init() {
        if (!$this->lang)
            $this->lang = 'ru';
    }

    protected function getCity($data) {
        $value = null;

        if (isset($data['city']['names'][$this->lang])) {
            $value = $data['city']['names'][$this->lang];
        }

        return $value;
    }
    protected function getCityGeoname($data) {
        $value = null;

        if (isset($data['city']['geoname_id'])) {
            $value = $data['city']['geoname_id'];
        }

        return $value;
    }

    protected function getCountry($data) {
        $value = null;

        if (isset($data['country']['names'][$this->lang])) {
            $value = $data['country']['names'][$this->lang];
        }

        return $value;
    }
    protected function getCountryGeoname($data) {
        $value = null;

        if (isset($data['country']['geoname_id'])) {
            $value = $data['country']['geoname_id'];
        }

        return $value;
    }

    protected function getLocation($data) {
        $value = new Location();

        if (isset($data['location'])) {
            $lat = $data['location']['latitude'];
            $lng = $data['location']['longitude'];
            $value = new Location($lat, $lng);
        }

        return $value;
    }

    protected function getCountryIso($data) {
        $value = null;

        if (isset($data['country']['iso_code'])) {
            $value = $data['country']['iso_code'];
        }

        return $value;
    }

    protected function getSubdivisionIso($data) {
        $value = null;

        if ( count($data['subdivisions']) > 0 ) {
            $subdivision = $data['subdivisions'][0];
            if (isset($subdivision['iso_code'])) {
                $value = $subdivision['iso_code'];
            }
        }

        return $value;
    }
    protected function getSubdivisionGeoname($data) {
        $value = null;

        if ( count($data['subdivisions']) > 0 ) {
            $subdivision = $data['subdivisions'][0];
            if (isset($subdivision['geoname_id'])) {
                $value = $subdivision['geoname_id'];
            }
        }

        return $value;
    }

    public function isDetected() {
        return ($this->location->lat !== null && $this->location->lng !== null);
    }
}
