<!DOCTYPE html>
<html>

<head>
    <title>Distributor Lead</title>
</head>

<body>
    <p>Hello</p>

    <p>You have been assigned a new lead by {{ $user->name }}.</p>

    <p>Here are the details of the lead:</p>
    <ul>
        <li><strong>Customer Name:</strong> {{ $sales_activity->customer_name }}</li>
        <li><strong>Company Name:</strong> {{ $sales_activity->company_name }}</li>
        <li><strong>Customer Designation:</strong> {{ $sales_activity->designation }}</li>
        <li><strong>Email:</strong> {{ $sales_activity->email ?? 'NA' }}</li>
        <li><strong>Mobile:</strong> {{ $sales_activity->phone }}</li>
        <li><strong>Opportunity:</strong> {{ $sales_activity->opportunity ?? 'NA' }}</li>
        <li><strong>City:</strong> {{ $sales_activity->city ?? 'NA' }}</li>
        <li><strong>State:</strong> {{ $sales_activity->state ?? 'NA' }}</li>
    </ul>

    <p>Important: Do not reply to this email as it is auto-generated.</p>

    <p>Best Regards,<br>
        Rayzon Solar Pvt. Ltd.
    </p>
</body>

</html>
