<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Common\Common;
use App\Classes\Models\City\City;
use App\Classes\Models\User\User;
use App\Classes\Helpers\Roles\Helper as HelperRoles;
use Illuminate\Support\Facades\Auth;
use App\Classes\Helpers\SearchHelper;
use App\Classes\Models\State\State;

class CommonController extends Controller
{
    protected $cityObj;
    protected $stateObj;
    protected $userObj;
    protected $_helperRoles;

    public function __construct()
    {

        $this->cityObj = new City();
        $this->stateObj = new State();
        $this->userObj = new User();
        $this->_helperRoles = new HelperRoles();
    }

    public function getPasswordGenerate( Request $request )
    {
        $data = $request->all();
        $validator = \Validator::make( $data, ['password' => 'required'] );

        if ( $validator->fails() ) {
            $response = ['success' => false,
                         'data'    => '',
                         'errors'  => $validator->errors()];
            return response()->json( $response, 422 );
        }

        $password = Common::generatePassword( $data['password'] );
        $response = ['success' => true,
                     'data'    => $password];
        return response()->json( $response, 200 );
    }

    public function getStateDropdown( Request $request )
    {
        $data = $request->all();
        $countryId = $data['country_id'];

        if ( ! empty( $countryId ) && $countryId > 0 ) {
            $stateList = $this->stateObj->getDropDown( '', '', $countryId );
            return response()->json( $stateList );
        }
        return response()->json( false );
    }

    public function getCityDropdown( Request $request )
    {
        $data = $request->all();
        $stateId = $data['state_id'];

        if ( ! empty( $stateId ) && $stateId > 0 ) {
            $cityList = $this->cityObj->getDropDown( '', '', $stateId );
            return response()->json( $cityList );
        }
        return response()->json( false );
    }

    public function getClassSingleClassDropdown( Request $request )
    {
        $data = $request->all();
        $schoolId = $data['school_id'];
        if ( ! empty( $schoolId ) && $schoolId > 0 ) {
            $filter = ['school_id' => $schoolId];
            $searchHelperClasses = new SearchHelper( -1, -1, $selectColumns = ['class_id',
                                                                               'class_name'], $filter );
            $classDropDown = $this->classesObj->getList( $searchHelperClasses )
                                              ->pluck( 'class_name', 'class_id' );
            return response()->json( $classDropDown );
        }
        return response()->json( false );
    }

    public function getGradeDropdown( Request $request )
    {
        $data = $request->all();
        $schoolId = isset( $data['school_id'] ) ? $data['school_id'] : 0;
        if ( ! empty( $schoolId ) && $schoolId > 0 ) {
            $filter = ['school_id' => $schoolId];
            $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['grade_id',
                                                                        'grade_name'], $filter );
            $gradeDropDown = $this->gradeObj->getList( $searchHelper )
                                            ->pluck( 'grade_name', 'grade_id' );
            return response()->json( $gradeDropDown );
        }
        return response()->json( false );
    }

    public function getClassDropdown( Request $request )
    {
        $data = $request->all();
        $gradeId = $data['grade_id'];
        $schoolId = $data['school_id'];
        if ( ! empty( $schoolId ) && $schoolId > 0 && ! empty( $gradeId ) && $gradeId > 0 ) {
            $filter = ['school_id' => $schoolId,
                       'grade_id'  => $gradeId];
            $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['class_id',
                                                                        'class_name'], $filter );
            $classDropDown = $this->classesObj->getList( $searchHelper )
                                              ->pluck( 'class_name', 'class_id' );
            return response()->json( $classDropDown );
        }
        return response()->json( false );
    }

    public function getStudentDropdown( Request $request )
    {
        $data = $request->all();
        $schoolId = $data['school_id'];
        if ( ! empty( $schoolId ) && $schoolId > 0 ) {
            $studentRole = $this->_helperRoles->getStudentRoleId();
            $filter = ['school_id' => $schoolId,
                       'role_id'   => $studentRole];
            $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['*'], $filter );
            $studentLists = $this->userObj->getList( $searchHelper );
            $studentDropDownList = [];
            if ( $studentLists->count() > 0 ) {
                foreach ( $studentLists as $studentKey => $studentList ) {
                    $studentDropDownList[$studentList->user_id] = $studentList->getNameAttribute();
                }
            }
            return response()->json( $studentDropDownList );
        }
        return response()->json( false );
    }

    public function getStudentMultipleDropDown( Request $request )
    {
        $data = $request->all();
        $schoolId = $data['school_id'];
        if ( ! empty( $schoolId ) && $schoolId > 0 ) {
            $studentRole = $this->_helperRoles->getStudentRoleId();
            $filter = ['school_id' => $schoolId,
                       'role_id'   => $studentRole];
            $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['*'], $filter );
            $studentLists = $this->userObj->getList( $searchHelper );
            $studentDropDownList = [];
            if ( $studentLists->count() > 0 ) {
                foreach ( $studentLists as $studentKey => $studentList ) {
                    $studentDropDownList[$studentList->user_id] = $studentList->getNameAttribute();
                }
            }
            return response()->json( $studentDropDownList );
        }
        return response()->json( [] );
    }

    public function getUserDropDownBySchoolId( Request $request )
    {
        $data = $request->all();
        $roleId = $data['role_id'];
        $schoolId = $data['school_id'];
        if ( ! empty( $roleId ) && $roleId > 0 ) {
            //$filter = ['role_id' => $roleId,'school_id' => $schoolId, 'status' => 1, 'is_verified' => 1];
            //$searchHelper = new SearchHelper( -1, -1, $selectColumns = ['user_id','name'], $filter );
            //$userDropDown = $this->userObj->getList( $searchHelper )->pluck( 'name', 'user_id' );
            $userDropDown = $this->userObj->getDropDown( $prepend = '', $roleId, $schoolId, 1, 1 );
            return response()->json( $userDropDown );
        }
        return response()->json( false );
    }

    public function getUserDropDownByClubId( Request $request )
    {
        $data = $request->all();
        $roleId = $data['role_id'];
        $clubId = $data['club_id'];
        if ( ! empty( $roleId ) && $roleId > 0 ) {
            $filter = ['role_id'     => $roleId,
                       'club_id'     => $clubId,
                       'status'      => 1,
                       'is_verified' => 1];
            $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['*'], $filter );
            $studentLists = $this->userObj->getList( $searchHelper );
            $studentDropDownList = [];
            if ( $studentLists->count() > 0 ) {
                foreach ( $studentLists as $studentKey => $studentList ) {
                    $studentDropDownList[$studentList->user_id] = $studentList->getNameAttribute();
                }
            }
            return response()->json( $studentDropDownList );
        }
        return response()->json( false );
    }

    public function cityInsert( Request $request )
    {

        echo "<pre>";
        print_r( "Exit" );
        exit;
        $stateArray = ['Aba North',
                       'Aba South',
                       'Arochukwu',
                       'Bende',
                       'Ikwuano',
                       'Isiala Ngwa North',
                       'Isiala Ngwa South',
                       'Isuikwuato',
                       'Obi Ngwa',
                       'Ohafia',
                       'Osisioma',
                       'Ugwunagbo',
                       'Ukwa East',
                       'Ukwa West',
                       'Umuahia North',
                       'muahia South',
                       'Umu Nneochi'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 1];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Demsa',
                       'Fufure',
                       'Ganye',
                       'Gayuk',
                       'Gombi',
                       'Grie',
                       'Hong',
                       'Jada',
                       'Larmurde',
                       'Madagali',
                       'Maiha',
                       'Mayo Belwa',
                       'Michika',
                       'Mubi North',
                       'Mubi South',
                       'Numan',
                       'Shelleng',
                       'Song',
                       'Toungo',
                       'Yola North',
                       'Yola South'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 2];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Abak',
                       'Eastern Obolo',
                       'Eket',
                       'Esit Eket',
                       'Essien Udim',
                       'Etim Ekpo',
                       'Etinan',
                       'Ibeno',
                       'Ibesikpo Asutan',
                       'Ibiono-Ibom',
                       'Ika',
                       'Ikono',
                       'Ikot Abasi',
                       'Ikot Ekpene',
                       'Ini',
                       'Itu',
                       'Mbo',
                       'Mkpat-Enin',
                       'Nsit-Atai',
                       'Nsit-Ibom',
                       'Nsit-Ubium',
                       'Obot Akara',
                       'Okobo',
                       'Onna',
                       'Oron',
                       'Oruk Anam',
                       'Udung-Uko',
                       'Ukanafun',
                       'Uruan',
                       'Urue-Offong Oruko',
                       'Uyo'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 3];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Aguata',
                       'Anambra East',
                       'Anambra West',
                       'Anaocha',
                       'Awka North',
                       'Awka South',
                       'Ayamelum',
                       'Dunukofia',
                       'Ekwusigo',
                       'Idemili North',
                       'Idemili South',
                       'Ihiala',
                       'Njikoka',
                       'Nnewi North',
                       'Nnewi South',
                       'Ogbaru',
                       'Onitsha North',
                       'Onitsha South',
                       'Orumba North',
                       'Orumba South',
                       'Oyi'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 4];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Alkaleri',
                       'Bauchi',
                       'Bogoro',
                       'Damban',
                       'Darazo',
                       'Dass',
                       'Gamawa',
                       'Ganjuwa',
                       'Giade',
                       'Itas-Gadau',
                       'Jama are',
                       'Katagum',
                       'Kirfi',
                       'Misau',
                       'Ningi',
                       'Shira',
                       'Tafawa Balewa',
                       ' Toro',
                       ' Warji',
                       ' Zaki'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 5];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Brass',
                       'Ekeremor',
                       'Kolokuma Opokuma',
                       'Nembe',
                       'Ogbia',
                       'Sagbama',
                       'Southern Ijaw',
                       'Yenagoa'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 6];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Agatu',
                       'Apa',
                       'Ado',
                       'Buruku',
                       'Gboko',
                       'Guma',
                       'Gwer East',
                       'Gwer West',
                       'Katsina-Ala',
                       'Konshisha',
                       'Kwande',
                       'Logo',
                       'Makurdi',
                       'Obi',
                       'Ogbadibo',
                       'Ohimini',
                       'Oju',
                       'Okpokwu',
                       'Oturkpo',
                       'Tarka',
                       'Ukum',
                       'Ushongo',
                       'Vandeikya'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 7];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Abadam',
                       'Askira-Uba',
                       'Bama',
                       'Bayo',
                       'Biu',
                       'Chibok',
                       'Damboa',
                       'Dikwa',
                       'Gubio',
                       'Guzamala',
                       'Gwoza',
                       'Hawul',
                       'Jere',
                       'Kaga',
                       'Kala-Balge',
                       'Konduga',
                       'Kukawa',
                       'Kwaya Kusar',
                       'Mafa',
                       'Magumeri',
                       'Maiduguri',
                       'Marte',
                       'Mobbar',
                       'Monguno',
                       'Ngala',
                       'Nganzai',
                       'Shani'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 8];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }


        $stateArray = ['Abi',
                       'Akamkpa',
                       'Akpabuyo',
                       'Bakassi',
                       'Bekwarra',
                       'Biase',
                       'Boki',
                       'Calabar Municipal',
                       'Calabar South',
                       'Etung',
                       'Ikom',
                       'Obanliku',
                       'Obubra',
                       'Obudu',
                       'Odukpani',
                       'Ogoja',
                       'Yakuur',
                       'Yala'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 9];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Aniocha North',
                       'Aniocha South',
                       'Bomadi',
                       'Burutu',
                       'Ethiope East',
                       'Ethiope West',
                       'Ika North East',
                       'Ika South',
                       'Isoko North',
                       'Isoko South',
                       'Ndokwa East',
                       'Ndokwa West',
                       'Okpe',
                       'Oshimili North',
                       'Oshimili South',
                       'Patani',
                       'Sapele',
                       'Udu',
                       'Ughelli North',
                       'Ughelli South',
                       'Ukwuani',
                       'Uvwie',
                       'Warri North',
                       'Warri South',
                       'Warri South West'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 10];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Abakaliki',
                       'Afikpo North',
                       'Afikpo South',
                       'Ebonyi',
                       'Ezza North',
                       'Ezza South',
                       'Ikwo',
                       'Ishielu',
                       'Ivo',
                       'Izzi',
                       'Ohaozara',
                       'Ohaukwu',
                       'Onicha'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 11];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Akoko-Edo',
                       'Egor',
                       'Esan Central',
                       'Esan North-East',
                       'Esan South-East',
                       'Esan West',
                       'Etsako Central',
                       'Etsako East',
                       'Etsako West',
                       'Igueben',
                       'Ikpoba Okha',
                       'Orhionmwon',
                       'Oredo',
                       'Ovia North-East',
                       'Ovia South-West',
                       'Owan East',
                       'Owan West',
                       'Uhunmwonde'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 12];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Ado Ekiti',
                       'Efon',
                       'Ekiti East',
                       'Ekiti South-West',
                       'Ekiti West',
                       'Emure',
                       'Gbonyin',
                       'Ido Osi',
                       'Ijero',
                       'Ikere',
                       'Ikole',
                       'Ilejemeje',
                       'Irepodun-Ifelodun',
                       'Ise-Orun',
                       'Moba',
                       'Oye'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 13];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Aninri',
                       'Awgu',
                       'Enugu East',
                       'Enugu North',
                       'Enugu South',
                       'Ezeagu',
                       'Igbo Etiti',
                       'Igbo Eze North',
                       'Igbo Eze South',
                       'Isi Uzo',
                       'Nkanu East',
                       'Nkanu West',
                       'Nsukka',
                       'Oji River',
                       'Udenu',
                       'Udi',
                       'Uzo Uwani'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 14];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Abaji',
                       'Bwari',
                       'Gwagwalada',
                       'Kuje',
                       'Kwali',
                       'Municipal Area Council'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 15];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Akko',
                       'Balanga',
                       'Billiri',
                       'Dukku',
                       'Funakaye',
                       'Gombe',
                       'Kaltungo',
                       'Kwami',
                       'Nafada',
                       'Shongom',
                       'Yamaltu-Deba'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 16];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }


        $stateArray = ['Aboh Mbaise',
                       'Ahiazu Mbaise',
                       'Ehime Mbano',
                       'Ezinihitte',
                       'Ideato North',
                       'Ideato South',
                       'Ihitte-Uboma',
                       'Ikeduru',
                       'Isiala Mbano',
                       'Isu',
                       'Mbaitoli',
                       'Ngor Okpala',
                       'Njaba',
                       'Nkwerre',
                       'Nwangele',
                       'Obowo',
                       'Oguta',
                       'Ohaji-Egbema',
                       'Okigwe',
                       'Orlu',
                       'Orsu',
                       'Oru East',
                       'Oru West',
                       'Owerri Municipal',
                       'Owerri North',
                       'Owerri West',
                       'Unuimo'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 17];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Auyo',
                       'Babura',
                       'Biriniwa',
                       'Birnin Kudu',
                       'Buji',
                       'Dutse',
                       'Gagarawa',
                       'Garki',
                       'Gumel',
                       'Guri',
                       'Gwaram',
                       'Gwiwa',
                       'Hadejia',
                       'Jahun',
                       'Kafin Hausa',
                       'Kazaure',
                       'Kiri Kasama',
                       'Kiyawa',
                       'Kaugama',
                       'Maigatari',
                       'Malam Madori',
                       'Miga',
                       'Ringim',
                       'Roni',
                       'Sule Tankarkar',
                       'Taura',
                       'Yankwashi'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 18];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Birnin Gwari',
                       'Chikun',
                       'Giwa',
                       'Igabi',
                       'Ikara',
                       'Jaba',
                       'Jema a',
                       'Kachia',
                       'Kaduna North',
                       'Kaduna South',
                       'Kagarko',
                       'Kajuru',
                       'Kaura',
                       'Kauru',
                       'Kubau',
                       'Kudan',
                       'Lere',
                       'Makarfi',
                       'Sabon Gari',
                       'Sanga',
                       'Soba',
                       'Zangon Kataf',
                       'Zaria'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 19];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Ajingi',
                       'Albasu',
                       'Bagwai',
                       'Bebeji',
                       'Bichi',
                       'Bunkure',
                       'Dala',
                       'Dambatta',
                       'Dawakin Kudu',
                       'Dawakin Tofa',
                       'Doguwa',
                       'Fagge',
                       'Gabasawa',
                       'Garko',
                       'Garun Mallam',
                       'Gaya',
                       'Gezawa',
                       'Gwale',
                       'Gwarzo',
                       'Kabo',
                       'Kano Municipal',
                       'Karaye',
                       'Kibiya',
                       'Kiru',
                       'Kumbotso',
                       'Kunchi',
                       'Kura',
                       'Madobi',
                       'Makoda',
                       'Minjibir',
                       'Nasarawa',
                       'Rano',
                       'Rimin Gado',
                       'Rogo',
                       'Shanono',
                       'Sumaila',
                       'Takai',
                       'Tarauni',
                       'Tofa',
                       'Tsanyawa',
                       'Tudun Wada',
                       'Ungogo',
                       'Warawa',
                       'Wudil'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 20];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Bakori',
                       'Batagarawa',
                       'Batsari',
                       'Baure',
                       'Bindawa',
                       'Charanchi',
                       'Dandume',
                       'Danja',
                       'Dan Musa',
                       'Daura',
                       'Dutsi',
                       'Dutsin Ma',
                       'Faskari',
                       'Funtua',
                       'Ingawa',
                       'Jibia',
                       'Kafur',
                       'Kaita',
                       'Kankara',
                       'Kankia',
                       'Katsina',
                       'Kurfi',
                       'Kusada',
                       'Mai Adua',
                       'Malumfashi',
                       'Mani',
                       'Mashi',
                       'Matazu',
                       'Musawa',
                       'Rimi',
                       'Sabuwa',
                       'Safana',
                       'Sandamu',
                       'Zango'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 21];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Aleiro',
                       'Arewa Dandi',
                       'Argungu',
                       'Augie',
                       'Bagudo',
                       'Birnin Kebbi',
                       'Bunza',
                       'Dandi',
                       'Fakai',
                       'Gwandu',
                       'Jega',
                       'Kalgo',
                       'Koko Besse',
                       'Maiyama',
                       'Ngaski',
                       'Sakaba',
                       'Shanga',
                       'Suru',
                       'Wasagu Danko',
                       'Yauri',
                       'Zuru'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 22];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Adavi',
                       'Ajaokuta',
                       'Ankpa',
                       'Bassa',
                       'Dekina',
                       'Ibaji',
                       'Idah',
                       'Igalamela Odolu',
                       'Ijumu',
                       'Kabba Bunu',
                       'Kogi',
                       'Lokoja',
                       'Mopa Muro',
                       'Ofu',
                       'Ogori Magongo',
                       'Okehi',
                       'Okene',
                       'Olamaboro',
                       'Omala',
                       'Yagba East',
                       'Yagba West'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 23];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Asa',
                       'Baruten',
                       'Edu',
                       'Ekiti',
                       'Ifelodun',
                       'Ilorin East',
                       'Ilorin South',
                       'Ilorin West',
                       'Irepodun',
                       'Isin',
                       'Kaiama',
                       'Moro',
                       'Offa',
                       'Oke Ero',
                       'Oyun',
                       'Pategi'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 24];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Agege',
                       'Ajeromi-Ifelodun',
                       'Alimosho',
                       'Amuwo-Odofin',
                       'Apapa',
                       'Badagry',
                       'Epe',
                       'Eti Osa',
                       'Ibeju-Lekki',
                       'Ifako-Ijaiye',
                       'Ikeja',
                       'Ikorodu',
                       'Kosofe',
                       'Lagos Island',
                       'Lagos Mainland',
                       'Mushin',
                       'Ojo',
                       'Oshodi-Isolo',
                       'Shomolu',
                       'Surulere'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 25];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Akwanga',
                       'Awe',
                       'Doma',
                       'Karu',
                       'Keana',
                       'Keffi',
                       'Kokona',
                       'Lafia',
                       'Nasarawa',
                       'Nasarawa Egon',
                       'Obi',
                       'Toto',
                       'Wamba'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 26];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Agaie',
                       'Agwara',
                       'Bida',
                       'Borgu',
                       'Bosso',
                       'Chanchaga',
                       'Edati',
                       'Gbako',
                       'Gurara',
                       'Katcha',
                       'Kontagora',
                       'Lapai',
                       'Lavun',
                       'Magama',
                       'Mariga',
                       'Mashegu',
                       'Mokwa',
                       'Moya',
                       'Paikoro',
                       'Rafi',
                       'Rijau',
                       'Shiroro',
                       'Suleja',
                       'Tafa',
                       'Wushishi'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 27];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Abeokuta North',
                       'Abeokuta South',
                       'Ado-Odo Ota',
                       'Egbado North',
                       'Egbado South',
                       'Ewekoro',
                       'Ifo',
                       'Ijebu East',
                       'Ijebu North',
                       'Ijebu North East',
                       'Ijebu Ode',
                       'Ikenne',
                       'Imeko Afon',
                       'Ipokia',
                       'Obafemi Owode',
                       'Odeda',
                       'Odogbolu',
                       'Ogun Waterside',
                       'Remo North',
                       'Shagamu'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 28];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Akoko North-East',
                       'Akoko North-West',
                       'Akoko South-West',
                       'Akoko South-East',
                       'Akure North',
                       'Akure South',
                       'Ese Odo',
                       'Idanre',
                       'Ifedore',
                       'Ilaje',
                       'Ile Oluji-Okeigbo',
                       'Irele',
                       'Odigbo',
                       'Okitipupa',
                       'Ondo East',
                       'Ondo West',
                       'Ose',
                       'Owo'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 29];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Atakunmosa East',
                       'Atakunmosa West',
                       'Aiyedaade',
                       'Aiyedire',
                       'Boluwaduro',
                       'Boripe',
                       'Ede North',
                       'Ede South',
                       'Ife Central',
                       'Ife East',
                       'Ife North',
                       'Ife South',
                       'Egbedore',
                       'Ejigbo',
                       'Ifedayo',
                       'Ifelodun',
                       'Ila',
                       'Ilesa East',
                       'Ilesa West',
                       'Irepodun',
                       'Irewole',
                       'Isokan',
                       'Iwo',
                       'Obokun',
                       'Odo Otin',
                       'Ola Oluwa',
                       'Olorunda',
                       'Oriade',
                       'Orolu',
                       'Osogbo'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 30];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Afijio',
                       'Akinyele',
                       'Atiba',
                       'Atisbo',
                       'Egbeda',
                       'Ibadan North',
                       'Ibadan North-East',
                       'Ibadan North-West',
                       'Ibadan South-East',
                       'Ibadan South-West',
                       'Ibarapa Central',
                       'Ibarapa East',
                       'Ibarapa North',
                       'Ido',
                       'Irepo',
                       'Iseyin',
                       'Itesiwaju',
                       'Iwajowa',
                       'Kajola',
                       'Lagelu',
                       'Ogbomosho North',
                       'Ogbomosho South',
                       'Ogo Oluwa',
                       'Olorunsogo',
                       'Oluyole',
                       'Ona Ara',
                       'Orelope',
                       'Ori Ire',
                       'Oyo',
                       'Oyo East',
                       'Saki East',
                       'Saki West',
                       'Surulere'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 31];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Bokkos',
                       'Barkin Ladi',
                       'Bassa',
                       'Jos East',
                       'Jos North',
                       'Jos South',
                       'Kanam',
                       'Kanke',
                       'Langtang South',
                       'Langtang North',
                       'Mangu',
                       'Mikang',
                       'Pankshin',
                       'Qua an Pan',
                       'Riyom',
                       'Shendam',
                       'Wase'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 32];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Abua Odual',
                       'Ahoada East',
                       'Ahoada West',
                       'Akuku-Toru',
                       'Andoni',
                       'Asari-Toru',
                       'Bonny',
                       'Degema',
                       'Eleme',
                       'Emuoha',
                       'Etche',
                       'Gokana',
                       'Ikwerre',
                       'Khana',
                       'Obio Akpor',
                       'Ogba Egbema Ndoni',
                       'Ogu Bolo',
                       'Okrika',
                       'Omuma',
                       'Opobo Nkoro',
                       'Oyigbo',
                       'Port Harcourt',
                       'Tai'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 33];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Binji',
                       'Bodinga',
                       'Dange Shuni',
                       'Gada',
                       'Goronyo',
                       'Gudu',
                       'Gwadabawa',
                       'Illela',
                       'Isa',
                       'Kebbe',
                       'Kware',
                       'Rabah',
                       'Sabon Birni',
                       'Shagari',
                       'Silame',
                       'Sokoto North',
                       'Sokoto South',
                       'Tambuwal',
                       'Tangaza',
                       'Tureta',
                       'Wamako',
                       'Wurno',
                       'Yabo'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 34];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Ardo Kola',
                       'Bali',
                       'Donga',
                       'Gashaka',
                       'Gassol',
                       'Ibi',
                       'Jalingo',
                       'Karim Lamido',
                       'Kumi',
                       'Lau',
                       'Sardauna',
                       'Takum',
                       'Ussa',
                       'Wukari',
                       'Yorro',
                       'Zing'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 35];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Bade',
                       'Bursari',
                       'Damaturu',
                       'Fika',
                       'Fune',
                       'Geidam',
                       'Gujba',
                       'Gulani',
                       'Jakusko',
                       'Karasuwa',
                       'Machina',
                       'Nangere',
                       'Nguru',
                       'Potiskum',
                       'Tarmuwa',
                       'Yunusari',
                       'Yusufari'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 36];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        $stateArray = ['Anka',
                       'Bakura',
                       'Birnin Magaji Kiyaw',
                       'Bukkuyum',
                       'Bungudu',
                       'Gummi',
                       'Gusau',
                       'Kaura Namoda',
                       'Maradun',
                       'Maru',
                       'Shinkafi',
                       'Talata Mafara',
                       'Chafe',
                       'Zurmi'];
        foreach ( $stateArray as $state ) {
            $data = ['city_name' => trim( $state ),
                     'state_id'  => 37];
            \DB::table( 'ka_city' )
               ->insert( $data );
        }

        echo "<pre>";
        print_r( "Done" );
        exit;
    }

    public function getUserDropdown( Request $request )
    {
        $data = $request->all();
        $roleId = ! empty( $data['role_id'] ) ? $data['role_id'] : -1;

        $schoolRoleId = $this->_helperRoles->getSchoolRoleId();
        if ( $roleId == $schoolRoleId ) {
            $userDropDown = $this->userObj->getSchoolDropDownFlip( '', $status = 1, $prependKey = 0 );
        } else {

            $filter = ['role_id'     => $roleId,
                       'status'      => 1,
                       'is_verified' => 1];
            $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['*'], $filter, ['first_name' => 'ASC'] );
            $userDropDown = $this->userObj->getList( $searchHelper )
                                          ->pluck( 'user_id', 'name' );
        }
        $response = ['success' => false,
                     'data'    => []];

        if ( $userDropDown->count() > 0 ) {
            $response = ['success' => true,
                         'data'    => $userDropDown];
            return response()->json( $response );
        }
        return response()->json( $response );
    }

    public function getUserDropDownByRoleType( Request $request )
    {
        $data = $request->all();
        $roleId = $data['role_id'];
        if ( ! empty( $roleId ) && $roleId > 0 ) {
            $schoolRoleId = $this->_helperRoles->getSchoolRoleId();
            if ( $roleId == $schoolRoleId ) {
                $userDropDown = $this->userObj->getSchoolDropDown( '', $status = 1, $prependKey = 0 );
            } else {
                $userDropDown = $this->userObj->getDropDown( $prepend = '', $roleId, -1, 1, 1 );
            }
            return response()->json( $userDropDown );
        }
        return response()->json( false );
    }

    public function getClubDropdown( Request $request )
    {
        $data = $request->all();
        $schoolId = $data['school_id'];
        $dropDown = $this->clubObj->getDropDown( '', $schoolId );
        return response()->json( $dropDown );
    }

    public function getUserDropdownByClubIdForNotification( Request $request )
    {
        $data = $request->all();
        $clubId = $data['club_id'];
        $studentRoleId = $this->_helperRoles->getStudentRoleId();
        $filter = ['role_id_in' => [$studentRoleId],
                   'club_id'    => $clubId,
                   'status'      => 1,
                   'is_verified' => 1,
                   'is_fcm_token' => 1];
        $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['*'], $filter, ['first_name' => 'asc'] );
        $userLists = $this->userObj->getList( $searchHelper );
        $userDropDownList = [];
        if ( $userLists->count() > 0 ) {
            foreach ( $userLists as $userKey => $userList ) {
                $userDropDownList[$userList->user_id] = $userList->getNameAttribute();
            }
        }
        return response()->json( $userDropDownList );
    }

    public function getGradeDropdownForNotification( Request $request )
    {
        $data = $request->all();
        $filter = [];
        $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['grade_id',
                                                                    'grade_name'], $filter, ['grade_name' => 'asc'] );
        $gradeDropDown = $this->gradeObj->getList( $searchHelper )
                                        ->pluck( 'grade_name', 'grade_id' );
        return response()->json( $gradeDropDown );
    }

    public function getClassDropdownByGradeId( Request $request )
    {
        $data = $request->all();
        $gradeId = $data['grade_id'];
        $classDropDown = $this->classesObj->getDropDown( 0, 1, $gradeId );
        return response()->json( $classDropDown );
    }

    public function getUserDropdownByClassIdForNotification( Request $request )
    {
        $data = $request->all();
        $classId = $data['class_id'];
        $gradeId = $data['grade_id'];
        $schoolId = $data['school_id'];

        $roleId = '';
        $parentIdLists = [];
        if ( $data['role_id'] == $this->_helperRoles->getTeacherRoleId() ) {
            $roleId = $this->_helperRoles->getTeacherRoleId();
        }
        if ( $data['role_id'] == $this->_helperRoles->getParentRoleId() ) {
            $roleId = $this->_helperRoles->getStudentRoleId();
            $filter = ['role_id_in' => [$roleId],
                       'class_id'   => $classId,
                       'grade_id'   => $gradeId,
                       'school_id'   => $schoolId,
                       'status'      => 1,
                       'is_verified' => 1,
                       'is_fcm_token' => 1];
            $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['student_parent.parent_id'], $filter, ['first_name' => 'asc'],['student_parent.parent_id'] );
            $parentIdLists = $this->userObj->getList( $searchHelper )->where('parent_id', '>', 0 )->pluck('parent_id')->toArray();
            $roleId = $this->_helperRoles->getParentRoleId();
            $classId = "";
            $gradeId = "";
            if(empty($parentIdLists)){
                $parentIdLists = [-1];
            }
        }

        $filter = ['role_id_in' => [$roleId],
                   'class_id'   => $classId,
                   'grade_id'   => $gradeId,
                   'school_id'   => $schoolId,
                   'user_id_in'   => $parentIdLists,
                   'status'      => 1,
                   'is_verified' => 1,
                   'is_fcm_token' => 1];

        $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['*'], $filter, ['first_name' => 'asc'] );
        $userLists = $this->userObj->getList( $searchHelper );
        $userDropDownList = [];
        if ( $userLists->count() > 0 ) {
            foreach ( $userLists as $userKey => $userList ) {
                $userDropDownList[$userList->user_id] = $userList->getNameAttribute();
            }
        }
        return response()->json( $userDropDownList );
    }

    public function getParentDropDownWithFilter( Request $request )
    {
        $data = $request->all();
        $parentRoleId = $this->_helperRoles->getParentRoleId();
        $schoolId = $data['school_id'];
        $filter = ['role_id'     => $parentRoleId,
                   'school_id'   => $schoolId,
                   'status'      => 1,
                   'is_verified' => 1];
        $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['*'], $filter, ['first_name' => 'ASC'] );
        $userDropDown = $this->userObj->getList( $searchHelper )
                                      ->pluck( 'user_id', 'name' );
        $response = ['success' => true,
                     'data'    => []];
        if ( $userDropDown->count() > 0 ) {
            $response = ['success' => true,
                         'data'    => $userDropDown];
            return response()->json( $response );
        }
        return response()->json( $response );
    }
}
