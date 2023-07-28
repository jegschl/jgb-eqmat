<?php 

define(
    'JGB_EQMAT_JOB_ORDER_STATUS',
    [
        'LPE' => 'LISTA PARA ENTREGA',
        'EPM' => 'EN PROCESO REPARACION/MANTENCION',
        'REC' => 'RECEPCIONADO',
        'EIL' => 'EN ESPERA INGRESO A LINEA',
        'PMT' => 'EN PROCESO DE MONTAJE',
        'EVL' => 'EN EVALUACION',
        'EOC' => 'EN ESPERA ORDEN DE COMPRA'
    ]
);

class EqmatHelper{
    public static function job_order_status( $jocode = null ){
        $joss = EqmatHelper::get_job_order_statuses_list();
        if( key_exists( $jocode, $joss ) ){
            $rdjos = apply_filters('jgb_eqmat_order_status_' . $jocode, $joss[$jocode] );
            return $rdjos;
        }

        return null;
    }

    public static function get_job_order_statuses_list(){
        $joss = apply_filters('jgb_eqmat_default_orders_statuses',JGB_EQMAT_JOB_ORDER_STATUS);

        return $joss;
    }
}