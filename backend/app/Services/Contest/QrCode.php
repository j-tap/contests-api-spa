<?php

namespace app\Services\Contest;

use danog\MadelineProto\stats;
use SimpleSoftwareIO\QrCode\Facades\QrCode as FacadesQrCode;

class QrCode
{
    const COMPANY_COLORS = [[28, 28, 28], [90, 90, 90]];

    public string $qr;
    public string $bg;
    public string $theme;

    private int $color;
    private array $colors;
    private string $content;

    /**
     * @param  string $content
     * @param  int $color
     * @param  array $colors
     */
    public function __construct(string $content, int $color = 0, array $colors = [])
    {
        $this->colors = [];

        foreach ($colors as &$hex)
        {
            $this->colors[] = self::hexToRgb($hex);
        }

        if (isset($color))
        {
            $colors = $this->getColors();
            $this->color = $color > count($colors) - 1 ? 0 : $color;
        }
        $this->content = $content;

        $this->generate();
    }

    /**
     * Получение массива цветов для ротации
     *
     */
    private function getColors()
    {
        $colors = self::COMPANY_COLORS;

        if (!empty($this->colors))
        {
            $colors = $this->colors;
        }

        return [
            [ $colors[0], [250, 250, 250], 'light' ],
            [ $colors[1], [250, 250, 250], 'light' ],
            [ [250, 250, 250], $colors[0], 'dark' ],
            [ [250, 250, 250], $colors[1], 'dark' ],
        ];
    }

    /**
     * Генерация QR кода
     *
     */
    private function generate()
    {
        $colors = $this->getColors();
        $color = $this->color;
        list($r1, $g1, $b1) = $colors[$color][0];
        list($r2, $g2, $b2) = $colors[$color][1];

        /* Создание QR кода */
        $qr = FacadesQrCode::color($r1, $g1, $b1)
            ->backgroundColor($r2, $g2, $b2)
            ->generate($this->content);

        /* установка нового цвета */
        $newColor = $color >= count($colors) - 1 ? 0 : $color + 1;

        $this->qr = $qr;
        $this->number_color = $newColor;
        $this->bg = 'rgb('. implode(', ', $colors[$color][1]) .')';
        $this->theme = $colors[$color][2];
    }

    /**
     * Color hex to rgb
     *
     * @param  string $hex
     * @return array
     */
    private static function hexToRgb(string $hex): array
    {
        $int = hexdec($hex);
        return array(0xFF & ($int >> 0x10), 0xFF & ($int >> 0x8), 0xFF & $int);
    }
}
