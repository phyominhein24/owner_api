<?php

namespace App\Enums;


enum PermissionEnum: string
{

    /** OWNER */
    case OWNER_INDEX = 'Owner_All';
    case OWNER_SHOW = 'Owner_Detail';
    case OWNER_STORE = 'Owner_Create';
    case OWNER_UPDATE = 'Owner_Update';
    case OWNER_DESTROY = 'Owner_Delete';

    /** CORNER */
    case CORNER_INDEX = 'Corner_All';
    case CORNER_SHOW = 'Corner_Detail';
    case CORNER_STORE = 'Corner_Create';
    case CORNER_UPDATE = 'Corner_Update';
    case CORNER_DESTROY = 'Corner_Delete';

    /** CITY */
    case CITY_INDEX = 'City_All';
    case CITY_SHOW = 'City_Detail';
    case CITY_STORE = 'City_Create';
    case CITY_UPDATE = 'City_Update';
    case CITY_DESTROY = 'City_Delete';

    /** TOWNSHIP */
    case TOWNSHIP_INDEX = 'Township_All';
    case TOWNSHIP_SHOW = 'Township_Detail';
    case TOWNSHIP_STORE = 'Township_Create';
    case TOWNSHIP_UPDATE = 'Township_Update';
    case TOWNSHIP_DESTROY = 'Township_Delete';

    /** WARD */
    case WARD_INDEX = 'Ward_All';
    case WARD_SHOW = 'Ward_Detail';
    case WARD_STORE = 'Ward_Create';
    case WARD_UPDATE = 'Ward_Update';
    case WARD_DESTROY = 'Ward_Delete';

    /** STREET */
    case STREET_INDEX = 'Street_All';
    case STREET_SHOW = 'Street_Detail';
    case STREET_STORE = 'Street_Create';
    case STREET_UPDATE = 'Street_Update';
    case STREET_DESTROY = 'Street_Delete';

    /** WIFI */
    case WIFI_INDEX = 'Wifi_All';
    case WIFI_SHOW = 'Wifi_Detail';
    case WIFI_STORE = 'Wifi_Create';
    case WIFI_UPDATE = 'Wifi_Update';
    case WIFI_DESTROY = 'Wifi_Delete';

    /** LAND */
    case LAND_INDEX = 'Land_All';
    case LAND_SHOW = 'Land_Detail';
    case LAND_STORE = 'Land_Create';
    case LAND_UPDATE = 'Land_Update';
    case LAND_DESTROY = 'Land_Delete';

    /** RENTER */
    case RENTER_INDEX = 'Renter_All';
    case RENTER_SHOW = 'Renter_Detail';
    case RENTER_STORE = 'Renter_Create';
    case RENTER_UPDATE = 'Renter_Update';
    case RENTER_DESTROY = 'Renter_Delete';

    /** OWNER DATA */
    case OWNER_DATA_INDEX = 'Owner_Data_All';
    case OWNER_DATA_SHOW = 'Owner_Data_Detail';
    case OWNER_DATA_STORE = 'Owner_Data_Create';
    case OWNER_DATA_UPDATE = 'Owner_Data_Update';
    case OWNER_DATA_DESTROY = 'Owner_Data_Delete';

    /** ROLE */
    case ROLE_INDEX = 'Role_All';
    case ROLE_SHOW = 'Role_Detail';
    case ROLE_STORE = 'Role_Create';
    case ROLE_UPDATE = 'Role_Update';
    case ROLE_DESTROY = 'Role_Delete';

    /** USER */
    case USER_INDEX = 'User_All';
    case USER_SHOW = 'User_Detail';
    case USER_STORE = 'User_Create';
    case USER_UPDATE = 'User_Update';
    case USER_DESTROY = 'User_Delete';

    /** PERMISSION */
    case PERMISSION_INDEX = 'Permission_All';
    case PERMISSION_SHOW = 'Permission_Detail';

    /** AUTH */
    case AUTH_UPDATE = 'Auth_Update';
    case DASHBOARD_INDEX = 'Dashboard_All';
}
