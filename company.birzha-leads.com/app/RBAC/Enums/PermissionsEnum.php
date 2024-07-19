<?php

namespace App\RBAC\Enums;

enum PermissionsEnum: string
{
    case editUsers = 'editUsers';
    case editClients = 'editClients';
    case editUserPermissions = 'editUserPermissions';
    case editFunnels = 'editFunnels';
    case viewSkorozvonTable = 'viewSkorozvonTable';
    case importClients = 'importClients';
    case allStat = 'allStat';
}