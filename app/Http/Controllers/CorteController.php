<?php

namespace App\Http\Controllers;

use App\Models\Corte;
use App\Models\Caja;
use App\Models\Pedido;
use App\Models\CorteHasPedidos;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use App\Http\Requests\Corte\Calcular;
use App\Http\Requests\Corte\Create;
use App\Http\Requests\Corte\Delete;
use App\Http\Requests\Corte\Read;
use App\Http\Requests\Corte\Imprimir;
use \Mpdf\Mpdf as PDF;

class CorteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idCaja)
    {
        try {
            
            if( auth()->user()->id ){

                $caja = Caja::find( $idCaja );
                $cortes = Corte::all();

                return view('cajas.cortes.index', compact('cortes', 'caja'));

            }else{

                return redirect('/');

            }

        } catch (\Throwable $th) {
            
            return redirect('/');

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Calcular $request)
    {
        try {
            
            $total = 0;
            $pedidos = Pedido::where('estatus', '=', 'Pagado')->get();

            foreach($pedidos as $pedido){

                $total += $pedido->total;

            }

            if( $total > 0 ){

                $datos['exito'] = true;
                $datos['total'] = $total;

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Monto insuficiente.';

            }

            

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Create $request)
    {
        try {

            $pedidos = Pedido::where('estatus', '=', 'Pagado')->get();

            if( count($pedidos) > 0 ){

                $corte = Corte::create([

                    'nombre' => $request->nombre,
                    'total' => $request->total,
                    'idCaja' => $request->idCaja
    
                ]);

                $corte = Corte::latest()->first();

                foreach($pedidos as $pedido){

                    $corteHasPed = CorteHasPedidos::create([

                        'idCorte' => $corte->id,
                        'idPedido' => $pedido->id

                    ]);

                    $pedido->estatus = 'Corte';
                    $pedido->save();

                }

                $movimiento = Movimiento::create([

                    'concepto' => $corte->nombre,
                    'tipo' => 'Corte',
                    'monto' => $corte->total,
                    'idCaja' => $corte->idCaja

                ]);

                if( $movimiento->id ){

                    $caja = Caja::find( $movimiento->idCaja );
                    $caja->total += $movimiento->monto;
                    $caja->save();
                    
                }

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Display the specified resource.
     */
    public function show($idCorte)
    {
        try {
            
            $corte = Corte::find( $idCorte );

            $pedidos = Pedido::select('pedidos.id', 'pedidos.total', 'pedidos.tipo', 'pedidos.idCliente')
                ->join('corte_has_pedidos', 'pedidos.id', '=', 'corte_has_pedidos.idPedido')
                ->where('corte_has_pedidos.idCorte', '=', $idCorte)
                ->get();

            return view('cajas.cortes.corte', compact('corte', 'pedidos'));

        } catch (\Throwable $th) {
            
            return redirect('/');

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Imprimir $request)
    {
        try {
            
            $totalDelivery = 0;
            $totalPickup = 0;
            $corte = Corte::find( $request->id );

            $pedidosDelivery = Pedido::select('pedidos.total')
                ->join('corte_has_pedidos', 'pedidos.id', '=', 'corte_has_pedidos.idPedido')
                ->where('corte_has_pedidos.idCorte', '=', $corte->id)
                ->where('pedidos.tipo', '=', 'delivery')
                ->get();

            foreach( $pedidosDelivery as $pedido ){

                $totalDelivery += $pedido->total;

            }

            $pedidosPickup = Pedido::select('pedidos.total')
                ->join('corte_has_pedidos', 'pedidos.id', '=', 'corte_has_pedidos.idPedido')
                ->where('corte_has_pedidos.idCorte', '=', $corte->id)
                ->where('pedidos.tipo', '=', 'pickup')
                ->get();

            foreach( $pedidosPickup as $pedido ){

                $totalPickup += $pedido->total;
                
            }

            $ticket = new \Mpdf\Mpdf([

                'mode' => 'utf-8',
                'format' => [80, 2700],
                'orientation' => 'P',
                'autoPageBreak' => false,

            ]);

            $ticket->writeHTML('<p style="font-size: 18px; font-style: bold; text-align: center; padding: 0px;">Wings Mania</p>');
            $ticket->writeHTML('<p style="font-size: 10px; font-style: normal; text-align: center; padding: 0px;">'.date('Y-m-d H:m:s').'</p>');
            $ticket->writeHTML('<p style="font-size: 11px; font-style: bold; text-align: center; padding: 0px;">#'.$corte->id.'</p>');
            $ticket->writeHTML('<p style="font-size: 13px; font-style: bold; text-align: center;">Total de corte: $'.$corte->total.'</p>');
            $ticket->writeHTML('<p style="font-size: 13px; font-style: bold; text-align: center;">Total Delivery: $'.$totalDelivery.'</p>');
            $ticket->writeHTML('<p style="font-size: 13px; font-style: bold; text-align: center;">Pedidos Delivery:'.$pedidosDelivery->count().'</p>');
            $ticket->writeHTML('<p style="font-size: 13px; font-style: bold; text-align: center;">Total Pickup: $'.$totalPickup.'</p>');
            $ticket->writeHTML('<p style="font-size: 13px; font-style: bold; text-align: center;">Pedido Pickup:'.$pedidosPickup->count().'</p>');

            if( file_exists( public_path('cortes') ) ){

                $ticket->Output( public_path('cortes/').'corte'.$corte->id.'.pdf', \Mpdf\Output\Destination::FILE );

            }else{

                mkdir( public_path('cortes'), 0777, true );

                $ticket->Output( public_path('cortes/').'corte'.$corte->id.'.pdf', \Mpdf\Output\Destination::FILE );

            }

            $datos['exito'] = true;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Corte $corte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delete $request)
    {
        try {
            
            $corte = Corte::find( $request->id );

            if( $corte->id ){

                $corte->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
