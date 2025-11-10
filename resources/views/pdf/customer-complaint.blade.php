<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick Customer Complaint Closer Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .text-center {
            text-align: center;
        }

        .form-title {
            margin-bottom: 20px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            text-align: center;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="{{ URL::asset('image/header-logo.png') }}" alt="Logo"
            style="width: 150px; display: block; margin: 0 auto;">
        <div class="text-center">
            <h4 class="form-title">Quick Customer Complaint Closer Form</h4>
        </div>
        <form>
            <table>
                <tr>
                    <td>Customer Name:</td>
                    <td colspan="2">{{ $complain->customer_name }}</td>
                </tr>
                <tr>
                    <td>Customer/Site Address:</td>
                    <td colspan="2">{{ $complain->customer_address }}</td>
                </tr>
                <tr>
                    <td>Invoice Number & Date:</td>
                    <td colspan="2">{{ $complain->invoice_photo }}</td>
                </tr>
                <tr>
                    <td>Module Type:</td>
                    <td colspan="2">{{ @$complain->product->name }}</td>
                </tr>
                <tr>
                    <td>Problem:</td>
                    <td colspan="2">{!! $complain->issue !!}</td>
                </tr>
                <td>Defective Qty:</td>
                <td colspan="2">{{ $complain->faulty_module_qty }}</td>
                </tr>
                <tr>
                    <td>Complaint Register Date:</td>
                    <td colspan="2">{{ $complain->created_at }}</td>
                </tr>
                <tr>
                    <td>Complaint Received by (Sales Team):</td>
                    <td colspan="2">{{ @$complain->salesPerson->name }}</td>
                </tr>
                <tr>
                    <td>Complaint Assigned to (Technical Team):</td>
                    <td colspan="2">{{ @$complain->assign_to->name }}</td>
                </tr>
                <tr>
                    <td>Complaint Details and Evidence:</td>
                    <td colspan="2">{{ $complain->complain_details }}</td>
                </tr>
                <tr>
                    <td>Action Taken:</td>
                    <td colspan="2">{{ $complain->action_taken }}</td>
                </tr>
                <tr>
                    <td>Complaint Closure Status with Date:</td>
                    <td colspan="2">{{ $complain->status }} - {{ $complain->updated_at }}</td>
                </tr>
                <tr>
                    <td>Customer Satisfaction Status (Yes/No):</td>
                    <td colspan="2">{{ $complain->customer_satisfication_status }}</td>
                </tr>
                <tr>
                    <td>Sales Team Satisfaction for Closure (Yes/No):</td>
                    <td colspan="2">{{ $complain->sales_team_satisfaction_status }}</td>
                </tr>
                <tr>
                    <td>
                        Sales Representative (Sign): <br>
                    </td>
                    <td>
                        <small>
                            {{ @$complain->salesPerson->name }} <br>
                            {{ date('d-m-Y') }}
                        </small>
                    </td>
                </tr>
                <tr>
                    <td>
                        Technical Representative (Sign): <br>
                    </td>
                    <td>
                        <small>
                            {{ @$complain->assign_to->name }} <br>
                            {{ date('d-m-Y') }}
                        </small>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>
