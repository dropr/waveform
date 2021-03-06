<?php

/**
 * Class Waveform
 */
class Waveform
{
    /**
     * @var string
     */
    private $lineMethod = 'imagelineNormal';
    
    /**
     * @var array amplitudes array
     */
    public $data = array();

    /**
     * @var array hex values of colors used during waveform generating
     */
    private $color = array(
        'background' => '#FFFFFF',
        'foreground' => '#000000'
    );
    
    /**
     * @var bool by default, always try to interpolate data
     */
    private $interpolate = TRUE;

    private $normalizeData = FALSE;

    /**
     * @param array $options
     */
    public function __construct(Array $options)
    {
        /* array of amplitudes */
        $this->data = $options['data'];

        /* spectrogram color*/
        $this->innerColor = $options['innerColor'];

        /* background color */
        $this->outerColor = $options['outerColor'];

        /* process original dimensions, padding etc. */
        $this->setDimensions($options);

        /* use interpolating to make spectrogram more smooth */
        $this->interpolate = isset($options['interpolate']) ? $options['interpolate'] : TRUE;
        $this->normalizeData = isset($options['normalizeData']) ? $options['normalizeData'] : TRUE;

        /* prepare GD image object */
        $this->createImage();
    }

    public function normalizeData()
    {
        $diff       = 0;
        $total      = 0;
        $expected   = 0.65;

        foreach ($this->data as $key => $value) {
            $total += $value;
        }

        $avg = $total/count($this->data);
        
        if($avg < $expected) {
            $diff = $expected - $avg;
        }

        foreach ($this->data as $key => $value) {
            $this->data[$key] = $value + (($value > 0) ? $diff : 0);
        }
    }

    private function setDimensions($options)
    {
        /* check if padding first */
        $this->horizontalPadding = isset($options['horizontalPadding']) ? ($options['horizontalPadding'] / 100) : 0;
        $this->verticalPadding   = isset($options['verticalPadding']) ? ($options['verticalPadding'] / 100) : 0;

        /* save original sizes */
        $this->originalWidth  = $options['width'];
        $this->originalHeight = $options['height'];

        /* image size */
        $this->width  = round($this->originalWidth - ($this->originalWidth * $this->horizontalPadding * 2));
        $this->height = round($this->originalHeight - ($this->originalHeight * $this->verticalPadding * 2));

        /* one side padding */
        $this->diffWidth  = ($this->originalWidth - $this->width) / 2;
        $this->diffHeight = ($this->originalHeight - $this->height) / 2;
    }

    /**
     * Prepare GD image object
     */
    private function createImage()
    {
        $this->img = imagecreatetruecolor($this->originalWidth, $this->originalHeight);

        /* prepare RGB values of background color */
        list($r, $g, $b) = $this->html2rgb($this->outerColor);
        $backgroundColor = imagecolorallocate($this->img, $r, $g, $b);

        /* fill image with background color */
        imagefill($this->img, 0, 0, $backgroundColor);
    }

    /**
     * @param $hexColor
     * @return array
     */
    private function html2rgb($hexColor)
    {
        $hexColor = ($hexColor[0] == "#") ? substr($hexColor, 1, 6) : substr($hexColor, 0, 6);

        return array(
            hexdec(substr($hexColor, 0, 2)),
            hexdec(substr($hexColor, 2, 2)),
            hexdec(substr($hexColor, 4, 2))
        );
    }

    /**
     * @param $method line rendering method
     * @throws Exception
     */
    public function setLineMethod($method)
    {
        $method = 'imageline' . ucfirst($method);

        if (!method_exists($this, $method)) {
            throw new Exception('Line rendering method ' . $method . ' not found!');
        }

        $this->lineMethod = $method;
    }

    /**
     * normalize data and create spectrogram
     */
    public function createWaveform()
    {
        /* process amplitudes values */
        $method             = ($this->interpolate) ? 'interpolateArray' : 'expandArray';
        $this->originalData = $this->data;
        $this->data         = ($this->$method($this->data, $this->width));
        $this->method       = $method;

        if($this->normalizeData) {
            $this->normalizeData();
        }

        /* draw spectrogram on image object */
        $this->createSpectogram();
    }

    /**
     * Draw spectrogram on image object
     */
    private function createSpectogram()
    {
        /* prepare spectrogram color in RGB values */
        list($r, $g, $b) = $this->html2rgb($this->innerColor);
        $innerColor = imagecolorallocate($this->img, $r, $g, $b);

        $dataSize = count($this->data);
        $middle   = $this->height / 2;

        foreach ($this->data as $i => $item) {
            $t = $this->width / $dataSize;

            $x1 = $t * $i + $this->diffWidth;
            $y1 = round($middle - $middle * $item) + $this->diffHeight;

            $x2 = $x1 + $t;
            $y2 = $y1 + round($middle * $item * 2);

            $lineMethodName = $this->lineMethod;
            $this->$lineMethodName($this->img, $x1, $y1, $x2, $y2, $innerColor);
        }
    }

    /**
     * @param $filename
     */
    public function toImage($filename)
    {
        imagepng($this->img, $filename);
        imagedestroy($this->img);
    }

    /**
     * @param $data
     * @param $fitCount
     * @return array
     */
    private function interpolateArray($data, $fitCount)
    {
        $newData      = array();
        $springFactor = ((count($data) - 1) / ($fitCount - 1));
        $newData[0]   = $data[0];

        $i = 1;

        while ($i < $fitCount - 1) {
            $tmp         = $i * $springFactor;
            $before      = round(floor($tmp));
            $after       = round(ceil($tmp));
            $atPoint     = $tmp - $before;
            $newData[$i] = $this->linearInterpolate($data[$before], $data[$after], $atPoint);
            $i++;
        }

        $newData[$fitCount - 1] = $data[count($data) - 1];
        return $newData;
    }

    /**
     * @param $before
     * @param $after
     * @param $atPoint
     * @return mixed
     */
    private function linearInterpolate($before, $after, $atPoint)
    {
        return $before + ($after - $before) * $atPoint;
    }

    /**
     * @param $data
     * @param $limit
     * @param int $defaultValue
     * @return array
     */
    private function expandArray($data, $limit, $defaultValue = 0)
    {
        $newData = array();

        if (count($data) > $limit) {
            $newData = array_slice($data, count($data) - $limit, count($data));
        } else {
            for ($i = 0; $i < $limit; $i++) {
                $newData[$i] = $data[$i] || $defaultValue;
            }
        }

        return $newData;
    }

    private function imagelineSmooth($image, $x1, $y1, $x2, $y2, $color)
    {
        for ($j = $y1; $j < $y2; $j++) {
            imagesetpixel($image, $x1, $j, $color);
        }
    }

    private function imagelineNormal($img, $x1, $y1, $x2, $y2, $innerColor)
    {
        imageline($img, $x1, $y1, $x2, $y2, $innerColor);
    }

    /**
     * function imageSmoothAlphaLine() - version 1.0
     * Draws a smooth line with alpha-functionality
     *
     * @param   ident    the image to draw on
     * @param   integer  x1
     * @param   integer  y1
     * @param   integer  x2
     * @param   integer  y2
     * @param   integer  red (0 to 255)
     * @param   integer  green (0 to 255)
     * @param   integer  blue (0 to 255)
     * @param   integer  alpha (0 to 127)
     *
     * @access  public
     *
     * @author  DASPRiD <d@sprid.de>
     */
    private function imagelineSmoothAlpha($image, $x1, $y1, $x2, $y2, $color, $alpha = 0)
    {
        list($r, $g, $b) = $this->html2rgb($color);

        $icr  = $r;
        $icg  = $g;
        $icb  = $b;
        $dcol = imagecolorallocatealpha($image, $icr, $icg, $icb, $alpha);

        if ($y1 == $y2 || $x1 == $x2) {
            imageline($image, $x1, $y2, $x1, $y2, $dcol);
        } else {
            $m = ($y2 - $y1) / ($x2 - $x1);
            $b = $y1 - $m * $x1;

            if (abs($m) < 2) {
                $x    = min($x1, $x2);
                $endx = max($x1, $x2) + 1;

                while ($x < $endx) {
                    $y  = $m * $x + $b;
                    $ya = ($y == floor($y) ? 1 : $y - floor($y));
                    $yb = ceil($y) - $y;

                    $trgb = imageColorAt($image, $x, floor($y));
                    $tcr  = ($trgb >> 16) & 0xFF;
                    $tcg  = ($trgb >> 8) & 0xFF;
                    $tcb  = $trgb & 0xFF;
                    imagesetpixel($image, $x, floor($y), imagecolorallocatealpha($image, ($tcr * $ya + $icr * $yb), ($tcg * $ya + $icg * $yb), ($tcb * $ya + $icb * $yb), $alpha));

                    $trgb = imageColorAt($image, $x, ceil($y));
                    $tcr  = ($trgb >> 16) & 0xFF;
                    $tcg  = ($trgb >> 8) & 0xFF;
                    $tcb  = $trgb & 0xFF;
                    imagesetpixel($image, $x, ceil($y), imagecolorallocatealpha($image, ($tcr * $yb + $icr * $ya), ($tcg * $yb + $icg * $ya), ($tcb * $yb + $icb * $ya), $alpha));

                    $x++;
                }
            } else {
                $y    = min($y1, $y2);
                $endy = max($y1, $y2) + 1;

                while ($y < $endy) {
                    $x  = ($y - $b) / $m;
                    $xa = ($x == floor($x) ? 1 : $x - floor($x));
                    $xb = ceil($x) - $x;

                    $trgb = imageColorAt($image, floor($x), $y);
                    $tcr  = ($trgb >> 16) & 0xFF;
                    $tcg  = ($trgb >> 8) & 0xFF;
                    $tcb  = $trgb & 0xFF;
                    imagesetpixel($image, floor($x), $y, imagecolorallocatealpha($image, ($tcr * $xa + $icr * $xb), ($tcg * $xa + $icg * $xb), ($tcb * $xa + $icb * $xb), $alpha));

                    $trgb = imageColorAt($image, ceil($x), $y);
                    $tcr  = ($trgb >> 16) & 0xFF;
                    $tcg  = ($trgb >> 8) & 0xFF;
                    $tcb  = $trgb & 0xFF;
                    imagesetpixel($image, ceil($x), $y, imagecolorallocatealpha($image, ($tcr * $xb + $icr * $xa), ($tcg * $xb + $icg * $xa), ($tcb * $xb + $icb * $xa), $alpha));

                    $y++;
                }
            }
        }
    }
}