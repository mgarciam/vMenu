<h1>vMenu</h1>
Hello! <i>{{ $ordermail->receiver }}</i>,
<p>Your order number {{$ordermail->number}} is in status: {{$ordermail->status}}</p>

If you have any questions, please contact us immediately, regards
<br/>
<i>{{ $ordermail->sender }}</i>