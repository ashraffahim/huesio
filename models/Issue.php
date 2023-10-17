<?php

namespace app\models;

class Issue extends databaseObjects\Issue {
    
    public const ISSUE_NAME_HEALTH = 'health';
    public const ISSUE_NAME_BEAUTY = 'beauty';
    public const ISSUE_NAME_AUTOMOBILE = 'automobile';

    public const ISSUE_ID_HEALTH = 1;
    public const ISSUE_ID_BEAUTY = 2;
    public const ISSUE_ID_AUTOMOBILE = 2;

    public const ISSUE_ID_TO_NAME = [
        self::ISSUE_ID_HEALTH => self::ISSUE_NAME_HEALTH,
        self::ISSUE_ID_BEAUTY => self::ISSUE_NAME_BEAUTY,
        self::ISSUE_ID_AUTOMOBILE => self::ISSUE_NAME_AUTOMOBILE
    ];
}

?>