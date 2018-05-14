<h1>vMenu</h1>
Hello! <i>{{ $bookedmail->receiver }}</i>,
<p>Welcome to Paradise Hotel. Your room is room number: <i>{{ $bookedmail->number }}</i> which price is <i>$ {{ $bookedmail->price }}</i> per night, your resgistration has been booked for <i>{{ $bookedmail->stay }}</i> days. Enjoy your stay!</p>

If you have any questions, please contact us immediately, regards
<br/>
<i>{{ $bookedmail->sender }}</i>