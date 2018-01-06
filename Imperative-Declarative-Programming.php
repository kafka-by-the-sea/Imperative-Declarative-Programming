<?php

//先介紹Imperative Programming的寫法(如下模樣的程式碼)
//特色：以for、if、array來做各種邏輯判斷，實作的細節
//可讀性比較低，無法一眼看出想表達什麼，要一層一層去拆解邏輯
function getUserEmails($users)
{
    $emails = [];
    for ($i = 0; $i < count($users); $i++) {
        $user = $users[$i];
        if ($user->email !== null) {
            $emails[] = $user->email;
        }
    }
    return $emails;
}

//另一種寫法叫做Declarative Programming(如下模樣的程式碼)
//Higher Order Functions，特色：可讀性比較高、可維護性也高，主要是把一些共同之處抽象化，不同的地方把它用closure封裝起來，
//變成是一種Fluent Style的寫法(大量使用Collection這個類別的function)

function getUserEmails($users)
{
    return $users
        ->filter(function($user) {
            return $user->email !== null && $user->name !== null;
        })
        ->map(function($user) {
            return $user->email; 
        });
}