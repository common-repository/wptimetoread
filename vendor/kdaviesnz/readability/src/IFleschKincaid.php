<?php


interface IFleschKincaid
{
    public function __toString();
    public function syllable_count(string $word) :int;
}