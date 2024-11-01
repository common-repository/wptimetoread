<?php


interface IReadability
{
    public function __toString();
    public function syllable_count(string $word) :int;
}