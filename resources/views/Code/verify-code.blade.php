<!DOCTYPE html>
<html>
<head>
    <title>Verificar Código</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gradient-to-tr from-red-950 to-teal-700 flex justify-center items-center min-h-screen p-4">

  <div class="bg-black/60 backdrop-blur-md text-white ring-8 ring-black/5 Xborder border-black/50 p-12 flex flex-col gap-6 shadow-lg rounded-xl w-full max-w-lg text-center relative overflow-hidden">

    <h1 class="text-xl font-bold tracking-wider">Verifica tu codigo</h1>
    <div class="text-xs space-y-2 *:leading-6">
      <p>Se te envio un codigo al correo  <strong>{{$email}}</strong>.</p>
      <p>Introduce el codigo para confirmar la session.</p>
    </div>

    <div class="flex gap-3 sm:gap-6 justify-center ">
    <form method="POST" action="{{ route('verify.code.submit') }}">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="text" id="code" name="code" maxlength="4" 
        class="bg-black/10 text-white border border-white/30 rounded-xl py-3 px-6 text-3xl sm:text-4xl max-w-xs w-32 text-center transition-all duration-300 focus:bg-black/90 focus:outline-none focus:ring-2 focus:ring-teal-500"
        placeholder="0000">
    </div>
    <button type="submit">Verificar</button>
    </form>
    <a type="button" id="btn-new-code"  
    class="w-fit mx-auto border border-white/30 bg-black/30  rounded-md py-2 px-4 uppercase font-thin transition-all duration-300 relative isolate overflow-hidden  hover:text-white focus-visible:text-white outline-none ring-0
                before:absolute
                before:-z-10
                before:inset-[100%_0]
                before:bg-red-900
                before:transition-all
                before:duration-300
                hover:before:inset-0
                focus-visible:before:inset-0

            ">send new code</a>

            @if ($errors->any())
            <div>{{ $errors->first() }}</div>
        @endif
 
  </div>

</body>
</html>
