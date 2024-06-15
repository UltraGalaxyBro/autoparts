<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Mail\Devolution;
use App\Models\Headquarter;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StoreController extends Controller
{
    //INDEX DO E-COMMERCE - INÍCIO
    public function index()
    {
        $products = Product::where('visible', 'Sim')->inRandomOrder()->limit(16)->get();
        if (Auth::check()) {
            $cart = session()->get('cart', []);
            return view('welcome', compact('products', 'cart'));
        } else {
            return view('welcome', compact('products'));
        }
    }
    //INDEX DO E-COMMERCE - FIM

    //CONTATOS DO E-COMMERCE - INÍCIO
    public function contacts()
    {
        $headquarters = Headquarter::where('visible', 'Sim')->get();

        if (Auth::check()) {
            $cart = session()->get('cart', []);
            return view('contacts', compact('cart', 'headquarters'));
        } else {
            return view('contacts', compact('headquarters'));
        }
    }

    public function clientEmailing(Request $request)
    {
        $request->validate(
            [
                'name' => ['required'],
                'email' => ['required', 'email'],
                'telephone' => ['required'],
                'subject' => ['required'],
                'nf' => ['required_if:subject,Devolução'],
                'reason' => ['required_if:subject,Devolução'],
                'terms' => ['required_if:subject,Devolução'],
                'message' => ['required', 'max:750'],
            ],
            [
                'name.required' => 'Informe seu nome, por gentileza.',
                'email.email' => 'Insira um email válido.',
                'email.required' => 'É neccessário informar seu e-mail.',
                'telephone.required' => 'É necessário inserir um número de telefone ou celular para contato.',
                'subject.required' => 'É necessário sinalizar qual o assunto da mensagem.',
                'nf.required_if' => 'Informe a nota fiscal do(s) produto(s).',
                'reason.required_if' => 'Informe o motivo da devolução.',
                'terms.required_if' => 'É necessário sinalizar que leu e aceita sobre as condições para devolução, além da legitimidade dos dados informados por você.',
                'message.max' => 'A sua mensagem deve ter no máximo 750 caracteres.',
                'message.required' => 'Preencha qual a mensagem que deseja nos enviar, seja sobre devolução ou qualquer outro assunto.'
            ]
        );

        if ($request->subject == 'Devolução') {
            
            $additionalEmails = ['exemplo.repcom@gmail.com'];
            //ENVIO DE E-MAIL DIFERENTE DO ASSUNTO DE DEVOLUÇÃO
            $email = Mail::to('contato@exemplo.com.br', 'CO2 Peças')->cc($additionalEmails)->send(mailable: new Devolution(data: [
                'fromName' => $request->name,
                'fromEmail' => $request->email,
                'fromTelephone' => $request->telephone,
                'isWhatsApp' => $request->whatsapp,
                'subject' => $request->subject,
                'nf' => $request->nf,
                'reason' => $request->reason,
                'message' => $request->message,
                'attachments' => $request->file('files'),
            ]));

        } else {
            //ENVIO DE E-MAIL DIFERENTE DO ASSUNTO DE DEVOLUÇÃO
            $email = Mail::to('lojavirtual@exemplo.com.br', 'E-commerce CO2 Peças')->send(mailable: new Contact(data: [
                'fromName' => $request->name,
                'fromEmail' => $request->email,
                'fromTelephone' => $request->telephone,
                'isWhatsApp' => $request->whatsapp,
                'subject' => $request->subject,
                'message' => $request->message
            ]));
        }

        if ($email) {
            return redirect()->route('contacts')->with('success', 'Envio efetuado com sucesso!');
        } else {
            Log::error('O cliente tentou enviar um e-mail de contato na página de contatos do e-commerce e acusou um erro no processo.');
            return redirect()->route('contacts')->with('error', 'Não foi possível enviar o e-mail por algum motivo. Solicite o suporte via WhatsApp para saber mais sobre!');
        }
    }
    //CONTATOS DO E-COMMERCE - FIM

    //POLÍTICAS DO E-COMMERCE - INÍCIO
    public function policies()
    {
        if (Auth::check()) {
            $cart = session()->get('cart', []);
            return view('policies', compact('cart'));
        } else {
            return view('policies');
        }
    }
    //POLÍTICAS DO E-COMMERCE - FIM

    //SOBRE DO E-COMMERCE - INÍCIO
    public function about()
    {
        if (Auth::check()) {
            $cart = session()->get('cart', []);
            return view('about', compact('cart'));
        } else {
            return view('about');
        }
    }
    //SOBRE DO E-COMMERCE - FIM

}
