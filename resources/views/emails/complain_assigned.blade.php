<!DOCTYPE html>
<html>
<head>
    <title>New Customer Complain Assigned</title>
</head>
<body>
    <p>Hello</p>

    <p>You have been assigned a new customer complain by {{ $complain->salesPerson->name }}. Please login the CRM and start the conversation.</p>

    <p>Here are the details of the complain:</p>
    <ul>
        <li><strong>Customer Name:</strong> {{ $complain->customer_name }}</li>
        <li><strong>Complain Date:</strong> {{ $complain->complain_date }}</li>
        <li><strong>Serial No:</strong> {{ $complain->serial_no }}</li>
        <li><strong>Product:</strong> {{ $complain->product->name }}</li>
        <li><strong>Faulty Module Qty:</strong> {{ $complain->faulty_module_qty }}</li>
        <li><strong>Project Capacity:</strong> {{ $complain->project_capacity }}</li>
        <li><strong>Issue:</strong> {!! $complain->issue !!} </li>
    </ul>

    <p>You can login to the CRM at <a href="{{ env('APP_URL') }}">{{ env('APP_URL') }}</a></p>

    <p>Important: Do not reply to this email as it is auto-generated.</p>

    <p>Best Regards,<br>{{ $complain->salesPerson->name }}</p>
</body>
</html>
