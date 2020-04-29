<?php

namespace Omnipay\CobrosYa;

use Omnipay\Common\Item as BaseItem;

class Item extends BaseItem
{
   /*  $post_data = [
        'token' => env('PAYMENT_TOKEN'),
        'id_transaccion' => openssl_random_pseudo_bytes(40),
        'nombre' => $user->perfil->name,
        'apellido' => $user->perfil->lastname,
        'email' => $user->email,
        'concepto' => env('APP_NAME'),
        'moneda' => w2_word_currency('pesos'),
        'monto' => is_a($precio_envio, 'Illuminate\Database\Eloquent\Model') ? $cart->total[w2_word_currency('pesos')] + $precio_envio->price : $cart->total[w2_word_currency('pesos')],
        'url_respuesta' => route('page.carrito.final')
    ];  */

    public function setIdTransaccion($id){
        $this->setParameter('id_transaccion',$id);
    } 
    
    public function getIdTransaccion(){
        $this->getParameter('id_transaccion');
    } 
    
    public function setNombre($value){
        $this->setParameter('nombre',$value);
    } 
    
    public function getNombre(){
      return $this->getParameter('nombre');
    }
    
    public function setApellido($value){
        $this->setParameter('apellido',$value);
    } 
    
    public function getApellido(){
        $this->getParameter('apellido');
    }
    
    public function setEmail($value){
        $this->setParameter('email',$value);
    } 
    
    public function getEmail(){
        $this->getParameter('email');
    }
    
    public function setConcepto($value){
        $this->setParameter('concepto',$value);
    } 
    
    public function getConcepto(){
        $this->getParameter('concepto');
    }
    
    public function setMoneda($value){
        $this->setParameter('moneda',$value);
    } 
    
    public function getMoneda(){
        $this->getParameter('moneda');
    }
    
    public function setMonto($value){
        $this->setParameter('monto',$value);
    } 
    
    public function getMonto(){
        $this->getParameter('moneda');
    }
}

?>
