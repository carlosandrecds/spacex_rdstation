<?php
    header('Content-type: application/json');

    //GET THE ROUTES FILE SCHEME
    require_once "route.php";

    //API REQUEST FOR ALL LAUNCHS
    class All {
        function AllLauch(){

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.spacexdata.com/v5/launches',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $data = curl_exec($curl);

            curl_close($curl);
            
            return $data;
        }
    }

    //API REQUEST FOR UPCOMING LAUNCHS
    class Upcoming {
        function UpcomingLauch(){

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.spacexdata.com/v5/launches/upcoming',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $data = curl_exec($curl);
            curl_close($curl);
            
            return $data;
        }
    }

    //API REQUEST FOR LAST LAUNCHS
    class Last {
        function LastLauch(){

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.spacexdata.com/v4/launches/past',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $data = curl_exec($curl);

            curl_close($curl);
            
            return $data;
        }
    }


    //ROUTES
    route('/', function(){
        $All = new All;
        return $All->AllLauch();
    });

    route('/upcoming', function(){
        $Upcoming = new Upcoming;
        return $Upcoming->UpcomingLauch();
    });

    route('/last', function(){
        $Last = new Last;
        return $Last->LastLauch();
    });

    $action = $_SERVER['REQUEST_URI'];
    dispatch($action);

