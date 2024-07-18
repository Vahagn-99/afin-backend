<?php

namespace App\Services\Syncer\Config;

interface Config
{
    const LOGIN_FIELD_ID = 499481;
    const ANALYTIC_FIELD_ID = 499463;
    const DEFAULT_BRANCH_NAME = "Отдел продаж";

    const CONTACT_ADDED_WEBHOOK = "add_contact";
    const CONTACT_UPDATED_WEBHOOK = "update_contact";
    const RATING_PIPELINE_ID = 8390486;
    const RATING_STATUSES_ID = [
        142
    ];
    const RATING_TYPE_LEADS_TOTAL = 'leads_total';
    const RATING_TYPE_DEPOSIT_TOTAL = 'deposit_total';
}