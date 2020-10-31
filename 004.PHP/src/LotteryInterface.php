<?php

namespace App;

interface LotteryInterface
{
    public function getNextDraw(): string;
}
