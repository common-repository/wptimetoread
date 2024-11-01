<?php

namespace kdaviesnz\wptimetoread;


interface IWPTimeToReadView
{
    public static function filterPost() :Callable;
    public static function addPostsTableColumnHeader() :Callable;
    public static function addPostsTableColumnContent() :Callable;
    public static function renderMetaboxes() :Callable;
}
