<?php
/**
 * File: customHelper.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 26/12/18
 * Time: 16:36
 * Project: lacc_acl
 * Copyright: 2018
 */


if ( !function_exists( 'dateHoraBR' ) ) {
    function dateHoraBR( $date )
    {
        if ( !$date instanceof \DateTime ) {
            $date = new DateTime( $date );
        }

        return $date->format( 'd-m-Y' );
    }

}
if ( !function_exists( 'dateHoraMinuteBR' ) ) {
    function dateHoraMinuteBR( $date )
    {
        if ( !$date instanceof \DateTime ) {
            $date = new DateTime( $date );
        }

        return $date->format( 'd-m-Y H:m:s' );
    }
}
if ( !function_exists( 'priceBR' ) ) {
    function priceBR( $price )
    {
        $price = number_format( $price, 2, ".", "" );

        return $price;
    }
}
if ( !function_exists( 'getObjectPusher' ) ) {
    function getObjectPusher( $chanel, $canal, $message )
    {
        $options = array(
            'encrypted' => true,
        );
        $pusher  = new \Pusher(
            env( 'PUSHER_APP_KEY' ),
            env( 'PUSHER_APP_SECRET' ),
            env( 'PUSHER_APP_ID' ),
            $options
        );

        return $pusher->trigger( $chanel, $canal, $message );
    }
}
if ( !function_exists( 'createMessage' ) ) {
    function createMessage( $varMsg, $type, $msg )
    {
        session()->flash( 'status', $type );
        session()->flash( $varMsg, $msg );
    }
}

if ( !function_exists( 'parseLocale' ) ) {
    function parseLocale()
    {
        $locale = Request::segment( 1 );

        $languages = [ 'pt-BR', 'es', 'fr', 'ru', 'en' ];

        if ( in_array( $locale, $languages ) ) {
            App::setLocale( $locale );

            return $locale;
        }

        return '/';
    }
}


if ( !function_exists( 'create_breadcrumb' ) ) {
    function create_breadcrumb( array $namedRoutes )
    {
        $result = [];
        if ( count( $namedRoutes ) ) {

            foreach ( $namedRoutes as $value ):
                $result[] = (object)[ 'url' => $value[ 0 ], 'title' => $value[ 1 ] ];
            endforeach;
        }

        return $result;
    }
}