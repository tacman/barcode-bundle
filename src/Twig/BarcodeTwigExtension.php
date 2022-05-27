<?php

namespace Tacman\BarcodeBundle\Twig;

use Picqer\Barcode\BarcodeGenerator;
use Picqer\Barcode\BarcodeGeneratorSVG;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class BarcodeTwigExtension extends AbstractExtension
{
    public function __construct(private int $widthFactor=2, private int $height=90, private string $foregroundColor='orange')
    {

    }
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('barcode', [$this, 'barcode'], ['is_safe' => ['html']]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('barcode', [$this, 'barcode'], ['is_safe' => ['html']]),
        ];
    }

    public function barcode(string $value, ?int $widthFactor = null, ?int $height = null, ?string $foregroundColor = null, string $type = BarcodeGenerator::TYPE_CODE_128): string
    {
        $generator = new BarcodeGeneratorSVG();
        $svg =  $generator->getBarcode($value, $type,
            $widthFactor ?? $this->widthFactor,
            $height ?? $this->height,
            $foregroundColor ?? $this->foregroundColor);
        return $svg;
        // ...
    }
}
