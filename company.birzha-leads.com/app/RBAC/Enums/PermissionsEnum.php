<?php

namespace App\RBAC\Enums;

enum PermissionsEnum: string
{
    case editUsers = 'editUsers';
    case editClients = 'editClients';
    case viewClients = 'viewClients';
    case clients = 'clients';
    case editUserPermissions = 'editUserPermissions';
    case editFunnels = 'editFunnels';
    case viewSkorozvonTable = 'viewSkorozvonTable';
    case importClients = 'importClients';
    case allStat = 'allStat';
    case viewStat = 'viewStat';
    case ViewRkoAlfa = 'ViewRkoAlfa';
    case EditRkoAlfa = 'EditRkoAlfa';
    case DemoAlfa = 'DemoRkoAlfa';
    case ViewRkoTinkoff = 'ViewRkoTinkoff';
    case EditRkoTinkoff = 'EditRkoTinkoff';
    case ViewRkoSber = 'ViewRkoSber';
    case EditRkoSber = 'EditRkoSber';
    case EditFunnel = 'EditFunnel';
    case EditAllFunnel = 'EditAllFunnel';
}