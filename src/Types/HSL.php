<?php

namespace MrColor\Types;

use MrColor\Types\Transformers\HslToRgb;
use MrColor\Types\Transformers\RgbToHex;

/**
 * Class HSL
 * @package MrColor\Types
 */
class HSL extends ColorType
{
    /**
     * @param $hue
     * @param $saturation
     * @param $lightness
     * @param $alpha
     */
    public function __construct($hue, $saturation, $lightness, $alpha = null)
    {
        $this->setAttributes([
            'hue' => $hue > 1 ? $hue / 360 : $hue,
            'saturation' => $saturation > 1 ? $saturation / 100 : $saturation,
            'lightness' => $lightness > 1 ? $lightness / 100: $lightness,
            'alpha' => $alpha > 1 ? $alpha / 100 : $alpha
        ]);
    }

    /**
     * @return Hex
     */
    public function hex()
    {
        return $this->rgb()->transform(new RgbToHex(), Hex::class);
    }

    /**
     * @return HSL
     */
    public function hsl()
    {
        return $this;
    }

    /**
     * @return RGB
     */
    public function rgb()
    {
        return $this->transform(new HslToRgb(), RGB::class);
    }

    /**
     * @return RGBA
     */
    public function rgba()
    {
        // TODO: Implement rgba() method.
    }

    /**
     * @return HSLA
     */
    public function hsla()
    {
        // TODO: Implement hsla() method.
    }

    /**
     * @return ARGB
     */
    public function argb()
    {
        // TODO: Implement argb() method.
    }

    /**
     * @return string
     */
    public function __toString()
    {
        list($hue, $saturation, $lightness) = $this->getValues();

        $alpha = $this->getAttribute('alpha');

        return $alpha ? "hsla({$hue}, {$saturation}%, {$lightness}%, {$this->getAttribute('alpha')})" :
            "hsl({$hue}, {$saturation}%, {$lightness}%)";
    }

    /**
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        $values = $this->getValues();

        $alpha = $this->getAttribute('alpha');

        ! $alpha ? : $values[] = $alpha;

        return json_encode(['hsl' => $values, 'css' => $this->__toString()], $options);
    }

    /**
     * @return array
     */
    private function getValues()
    {
        return [
            round($this->getAttribute('hue') * 360),
            round($this->getAttribute('saturation') * 100),
            round($this->getAttribute('lightness') * 100)
        ];
    }
}