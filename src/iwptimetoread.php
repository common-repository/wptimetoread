<?php

namespace kdaviesnz\wptimetoread;

interface IWPTimeToRead
{
    public function init();
    public function admin(): bool;
    public function metaBoxes( string $screen );
    public function foot();
    public function head();
    public function adminFoot();
    public function adminHead();
    public function onActivation():Callable;
    public function onDeactivation():Callable;
    public function onPluginsLoaded():Callable;
}
