<?php

namespace app\components\captcha;

class Captcha
{

    private const _UPLOADS = 'captcha';

    private const _WIDTH = 170;
    private const _HEIGHT = 70;

    private const _FONT = '../components/captcha/src/fonts/ds_moster.ttf';

    private $image;

    private $background_color;

    private $length = 6;
    private $string = 'AaBbC0cDdEe1FfGgH2hIiJj3KkLlM4mNnOo5PpQqR6rSsTt7UuVvW8wXxYy9Zz';
    private $size = 18;
    private $angle = [-25, 25];
    private $text_color;

    private $line = 6;

    private $name_image;
    private $answer;

    public function __construct()
    {
        if (!file_exists(self::_UPLOADS)) mkdir(self::_UPLOADS);
    }

    public function setBackgroundColor(array $rgb)
    {
        $this->background_color = $rgb;
    }

    public function setTextColor(array $rgb)
    {
        $this->text_color = $rgb;
    }

    public function setLength(int $length)
    {
        $this->length = $length;
    }

    public function setString(string $string)
    {
        if ($string) $this->string = $string;
    }

    public function setSize(float $size)
    {
        $this->size = $size;
    }

    public function setAngle(array $angle)
    {
        $this->angle = $angle;
    }

    public function setLine(int $line)
    {
        $this->line = $line;
    }

    public function getNameImage()
    {
        return self::_UPLOADS . '/' . $this->name_image;
    }

    public function getAnswer()
    {
        return $this->answer;
    }

    public function create()
    {
        $this->createImage();

        $this->background();

        $this->text();

        $this->effects();

        $this->name_image();

        $this->saveImage();

        $this->destroyImage();
        
    }

    private function createImage()
    {
        $this->image = imagecreate(self::_WIDTH, self::_HEIGHT);
    }

    private function background()
    {
        if(!$this->background_color) $this->background_color = [rand(0, 255), rand(0, 255), rand(0, 255)];

        imagecolorallocate($this->image, $this->background_color[0], $this->background_color[1], $this->background_color[2]);
    }

    private function text()
    {
        $w_symbol = floor(self::_WIDTH / $this->length);

        if (!$this->text_color) $this->text_color = ( array_sum($this->background_color) > 382 ) ? [0, 0, 0] : [255, 255, 255];

        $color = imagecolorallocate($this->image, $this->text_color[0], $this->text_color[1], $this->text_color[2]);

        for($i = 1; $i <= $this->length; $i++)
        {
            $symbol = substr($this->string, rand(0, iconv_strlen($this->string) - 1), 1);

            imagettftext(
                $this->image,
                $this->size,
                rand($this->angle[0], $this->angle[1]),
                rand(
                    ($w_symbol * $i - $w_symbol),
                    ($w_symbol * $i - $this->symbolSize($symbol)),
                ),
                rand(
                    $this->symbolSize($symbol, false),
                    self::_HEIGHT
                ),
                $color,
                self::_FONT,
                $symbol
            );

            $this->answer .= $symbol;
        }
   
    }

    private function effects()
    {
        for ($i = 0; $i < $this->line; $i++)
        {
            imageline(
                $this->image,
                rand(0, self::_WIDTH),
                rand(0, self::_HEIGHT),
                rand(0, self::_WIDTH),
                rand(0, self::_HEIGHT),
                imagecolorallocate($this->image, rand(0, 255), rand(0, 255), rand(0, 255))
            );
        }
    }

    private function name_image()
    {
        $this->name_image = str_replace(' ','_',str_replace('.', '', microtime())) . '.png';
    }

    private function saveImage()
    {
        imagepng($this->image, self::_UPLOADS . '/' . $this->name_image);
    }

    private function destroyImage()
    {
        imagedestroy($this->image);
    }

    private function symbolSize(string $symbol, bool $axis_x = true): int
    {
        $data = imagettfbbox($this->size, 0, self::_FONT, $symbol);

        if (!$axis_x) return $data[1] - $data[7];

        return $data[2] - $data[0];
    }

}