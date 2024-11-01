<?php
declare(strict_types=1);

namespace kdaviesnz\fleschkincaid;


use DaveChild\TextStatistics\Text;
use DaveChild\TextStatistics\TextStatistics;

class FleschKincaid

{

    public $data; // json string
    private $content;
    private $readingEase;

    /**
     * Readability constructor.
     */
    public function __construct(string $content)
    {

        $this->content = $content;
        $this->data = json_encode(array(
           "reading_ease"=>$this->reading_ease(),
            "reading_ease_description"=>$this->reading_ease_description(),
            "school_level"=>$this->school_level(),
            "clean_text"=>$this->clean_text(),
            "character_count"=>$this->character_count(),
            "text_length"=>$this->text_length(),
            "letter_count"=>$this->letter_count(),
            "word_count"=>$this->word_count(),
            "average_syllables_per_word"=>$this->average_syllables_per_word(),
            "percentage_words_with_three_Syllables"=>$this->percentage_words_with_three_Syllables(),
            "sentence_count"=>$this->sentence_count(),
            "average_words_per_sentence"=>$this->average_words_per_sentence(),
            "grade_level"=>$this->grade_level(),
            "gunning_fog_score"=>$this->gunning_fog_score(),
            "coleman_liau_index"=>$this->coleman_liau_index(),
            "smog_index"=>$this->smog_index(),
            "automated_readability_index"=>$this->automated_readability_index()
        ));
    }

    public function __toString()
    {
        return $this->data;
    }

    private function reading_ease_description():string
    {
        $description = "";
        $reading_ease = $this->reading_ease();
        if ($reading_ease <20) {
            $description = "Very difficult to read. Best understood by university graduates";
        } elseif($reading_ease >=20 && $reading_ease <50) {
            $description = "Difficult to read.";
        } elseif($reading_ease >=50 && $reading_ease <60) {
            $description = "Fairly difficult to read.";
        } elseif($reading_ease >=60 && $reading_ease <70) {
            $description = "Plain English. Easily understood by 13- to 15-year-old students.";
        } elseif($reading_ease >=70 && $reading_ease <80) {
            $description = "Fairly easy to read.";
        } elseif($reading_ease >=80 && $reading_ease <90) {
            $description = "Easy to read. Conversational English for consumers.";
        } elseif($reading_ease >90) {
            $description = "Very easy to read. Easily understood by an average 11-year-old student.";
        }
        return $description;
    }

    private function school_level():string
    {
        $description = "";
        $reading_ease = $this->reading_ease();
        if ($reading_ease <20) {
            $description = "College graduate";
        } elseif($reading_ease >=20 && $reading_ease <50) {
            $description = "College";
        } elseif($reading_ease >=50 && $reading_ease <60) {
            $description = "10th to 12th grade";
        } elseif($reading_ease >=60 && $reading_ease <70) {
            $description = "8th & 9th grade";
        } elseif($reading_ease >=70 && $reading_ease <80) {
            $description = "7th grade";
        } elseif($reading_ease >=80 && $reading_ease <90) {
            $description = "6th grade";
        } elseif($reading_ease >90) {
            $description = "5th grade";
        }
        return $description;
    }

    private function reading_ease():float {
        if (!empty($this->readingEase)) {
            return $this->readingEase;
        }
        $textStatistics = new TextStatistics();
        $this->readingEase = $textStatistics->flesch_kincaid_reading_ease($this->content);
        return $this->readingEase;
    }

    private function clean_text():string {
        return Text::cleanText($this->content);
    }

    private function character_count():int {
        return Text::characterCount($this->content);
    }

    private function text_length():int {
        return Text::textLength($this->content);
    }

    private function letter_count():int {
        return Text::letterCount($this->content);
    }

    private  function word_count():int {
        return Text::wordCount($this->content);
    }

    public function syllable_count( string $word ) :int{
        $textStatistics = new TextStatistics();
        return $textStatistics->syllableCount($word );
    }

    private function average_syllables_per_word():float
    {
        $textStatistics = new TextStatistics();
        return $textStatistics->averageSyllablesPerWord($this->content);
    }

    private function percentage_words_with_three_Syllables():float
    {
        $textStatistics = new TextStatistics();
        return $textStatistics->percentageWordsWithThreeSyllables($this->content);
    }

    private function sentence_count():int {
        $textStatistics = new TextStatistics();
        return $textStatistics->sentenceCount($this->content);
    }

    private function average_words_per_sentence():float {
        $textStatistics = new TextStatistics();
        return $textStatistics->averageWordsPerSentence($this->content);
    }

    private function grade_level():float {
        $textStatistics = new TextStatistics();
        return $textStatistics->flesch_kincaid_grade_level($this->content);
    }

    private function gunning_fog_score():float {
        $textStatistics = new TextStatistics();
        return $textStatistics->gunning_fog_score($this->content);
    }

    private function coleman_liau_index():float {
        $textStatistics = new TextStatistics();
        return $textStatistics->coleman_liau_index($this->content);
    }

    private function smog_index():float
    {
        $textStatistics = new TextStatistics();
        return $textStatistics->smog_index($this->content);
    }

    private function automated_readability_index():float {
        $textStatistics = new TextStatistics();
        return $textStatistics->automated_readability_index($this->content);
    }

}