<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public function dateFormat( $dateTime, $dateFormat )
    {
        if ( $dateFormat == 'format-1' ) {

            return Carbon::parse( $dateTime )
                         ->format( 'd, F Y' ); //20,December 2017
        }

        if ( $dateFormat == 'format-2' ) {

            return Carbon::parse( $dateTime )
                         ->format( 'n/j/Y h:i A' ); //  19/05/2018 12:44:11 PM
        }

        if ( $dateFormat == 'format-3' ) {

            return Carbon::parse( $dateTime )
                         ->format( 'n/j/Y' ); //  9/30/2014
        }

        if ( $dateFormat == 'format-4' ) {

            return Carbon::parse( $dateTime )
                         ->format( 'n-j-Y h:i:s A' ); //  9/28/2017 7:18:39 AM
        }
        if ( $dateFormat == 'format-5' ) {

            return Carbon::parse( $dateTime )
                         ->format( 'n-j-Y' ); //  09-30-2014
        }

        if ( $dateFormat == 'format-6' ) {

            return Carbon::parse( $dateTime )
                         ->format( 'n/j/Y' ); //  09/30/2014
        }

        if ( $dateFormat == 'format-7' ) {
            return Carbon::parse( $dateTime )
                         ->format( 'M j, Y ( g:i:s A )' ); // Feb 21, 2019 ( 09:32:17 AM )
        }

        if ( $dateFormat == 'format-8' ) {

            return Carbon::parse( $dateTime )
                         ->format( 'n/j/Y g:i a' ); //  19/05/2018 12:44:11 PM
        }

        if ( $dateFormat == 'format-9' ) {

            return Carbon::parse( $dateTime )
                         ->format( 'n/j/y (g:i a)' ); //  19/05/2018 12:44:11 PM
        }

        if ( $dateFormat == 'format-10' ) {

            return Carbon::parse( $dateTime )
                         ->format( 'n/j/Y g:i:s a' ); //  9/28/2017 7:18:39 AM
        }

        if ( $dateFormat == 'format-11' ) {
            return Carbon::parse( $dateTime )
                         ->format( 'F n/j/Y g:i A ' ); // March 03/25/2019 12:00 AM
        }

        if ( $dateFormat == 'format-12' ) {
            return Carbon::parse( $dateTime )
                         ->format( 'F n/j/Y' ); // March 03/25/2019
        }

        if ( $dateFormat == 'format-13' ) {
            return Carbon::parse( $dateTime )
                         ->format( '(n/j/y)' ); // (2/31/19)
        }

        if ( $dateFormat == 'format-14' ) {
            return Carbon::parse( $dateTime )
                         ->format( 'j/n/Y' ); //  9/30/2014
        }

        if ( $dateFormat == 'format-15' ) {
            return Carbon::parse( $dateTime )
                         ->format( 'Y/n/j' ); //  2014/9/30
        }

		if ( $dateFormat == 'format-16' ) {
            return Carbon::parse( $dateTime )
                         ->format( 'Y-m-d H:i:s' ); //  2014/9/30
        }
        if ( $dateFormat == 'format-17' ) {
            return Carbon::parse( $dateTime )
                         ->format( 'M j, Y ( g:i A )' );  //Nov 5, 2019 ( 1:48 AM )
        }
        if ( $dateFormat == 'format-18' ) {
            return Carbon::parse( $dateTime )
                         ->format( '(n/j/Y)' ); // (2/31/19)
        }

        if ( $dateFormat == 'format-datepicker' ) {
            return Carbon::parse( $dateTime )
                         ->format( 'm/d/Y' ); //  9/30/2014
        }
        if ( $dateFormat == 'time-format-1' ) {
            return Carbon::parse( $dateTime )
                         ->format( 'g:i A' ); // 12:30 AM
        }
        if ( $dateFormat == 'time-format-2' ) {
            return substr( Carbon::parse( $dateTime )
                                 ->format( 'g:i A' ), 0, -1 ); // 12:30 A
        }

        return $dateTime;
    }

    public function getCurrentDateTime( $dateFormat )
    {
        $dateTime = Carbon::now();

        if ( $dateFormat == 'format-1' ) {

            return Carbon::parse( $dateTime )
                         ->format( 'Y-m-d H:i:s' ); //  2019-02-21 19:00:13
        }

        if ( $dateFormat == 'format-2' ) {

            return Carbon::parse( $dateTime )
                         ->format( 'g:i A' ); //  19:00:13
        }

        if ( $dateFormat == 'format-3' ) {

            return Carbon::parse( $dateTime )
                         ->format( 'M d, Y' ); //  Feb 21, 2019
        }

        if ( $dateFormat == 'format-4' ) {

            return Carbon::parse( $dateTime )
                         ->format( 'l' ); //  Thursday
        }
        if ( $dateFormat == 'format-db' ) {

            return Carbon::parse( $dateTime )
                         ->format( 'm/d/Y' ); // 03/06/2020
        }

        return $dateTime;
    }
    public function getCurrentDateTimeWithRemoveDays($dateFormat, $days)
    {
        $dateTime = Carbon::now()->subDays($days);

        if ( $dateFormat == 'format-1' ) {

            return Carbon::parse($dateTime)->format('Y-m-d H:i:s');
        }
        return $dateTime;
    }

	public function isDateExpired($dateTime) {
		if(empty($dateTime)){ return true; }
        $dateTime = Carbon::parse($dateTime)->format( 'Y-m-d H:i:s' );
        $now = Carbon::now()->format( 'Y-m-d H:i:s' );
        if ( strtotime( $now ) > strtotime( $dateTime ) ) {
            return true;
        }
        return false;
    }

	public function getCurrentDateTimeWithRemoveHours($dateFormat, $hours)
    {
        $dateTime = Carbon::now()->subHours($hours);

        if ( $dateFormat == 'format-1' ) {

            return Carbon::parse($dateTime)->format('Y-m-d H:00:00');
        }
        return $dateTime;
    }
}


