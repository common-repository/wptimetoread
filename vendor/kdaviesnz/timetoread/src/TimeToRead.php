<?php
declare(strict_types=1);

namespace kdaviesnz\timetoread;

use kdaviesnz\fleschkincaid\FleschKincaid;

class TimeToRead implements \ITimetoRead
{

    public $data; // json string
    private $content;
    private $fc;

    /**
     * TimeToREad constructor.
     */
    public function __construct(string $content)
    {
        $this->content = $content;
        $temp = new FleschKincaid($this->content);
        $this->fc = json_decode($temp->data);

        $this->data = json_encode(array(
            "minutes" => $this->getMinutes(),
            "readability"=>$this->fc
        ));
    }

    public function __toString()
    {
        return $this->data;
    }

    public function getMinutes():float
    {
        /*
         https://en.wikipedia.org/wiki/Reading_%28process%29#Reading_rate
         Rates of reading include reading for memorization (fewer than 100 words per minute [wpm]); reading for learning (100–200 wpm); reading for comprehension (200–400 wpm); and skimming (400–700 wpm). Reading for comprehension is the essence of the daily reading of most people. Skimming is for superficially processing large quantities of text at a low level of comprehension (below 50%).
         */
        $readingRate = 0; // words per minute
        $reading_ease = $this->fc->reading_ease;
        $word_count = $this->fc->word_count;
        if ($reading_ease <20) {
           $readingRate = 100;
        } elseif($reading_ease >=20 && $reading_ease <50) {
            $readingRate = 200;
        } elseif($reading_ease >=50 && $reading_ease <60) {
            $readingRate = 300;
        } elseif($reading_ease >=60 && $reading_ease <70) {
           $readingRate = 350;
        } elseif($reading_ease >=70 && $reading_ease <80) {
            $readingRate = 400;
        } elseif($reading_ease >=80 && $reading_ease <90) {
            $readingRate = 500;
        } elseif($reading_ease >90) {
            $readingRate = 600;
        }

        $minutes = floor($word_count / $readingRate);
        return $minutes;
    }

}