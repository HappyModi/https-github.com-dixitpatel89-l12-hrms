<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .container { width: 100%; padding: 20px; border: 1px solid #000; }
        .title { text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 10px; }
        .logo { width: 100px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
        .green-box { background-color: #e0f7da; padding: 10px; font-size: 16px; font-weight: bold; text-align: center; }
        .note { font-size: 12px; margin-top: 10px; }
        .net-pay { text-align: center; font-size: 20px; font-weight: bold; color: green; }
    </style>
</head>
<body>
    <div class="container">
    <table>
    <tr>
        <td>
            <strong>{{ $company->name }}</strong><br>
            {{ $company->address }}<br>
            Email: {{ $company->email }}
        </td>
        <td align="right">
            @if($company->logo)
                <img src="{{ public_path('storage/' . $company->logo) }}" alt="Company Logo" class="logo">
            @else
                <img src="{{ public_path('images/default-logo.png') }}" alt="Default Logo" class="logo">
            @endif
        </td>
    </tr>
</table>


        <div class="title">Payslip for the month of {{ $month }}</div>

        <table>
            <tr>
                <td><strong>Employee Name:</strong> {{ $employee->full_name }}</td>
                <td><strong>Employee ID:</strong> {{ $employee->employee_id }}</td>
            </tr>
            <tr>
                <td><strong>Designation:</strong> {{ $employee->designation }}</td>
                <td><strong>Date of Joining:</strong> {{ $employee->joining_date }}</td>
            </tr>
            <tr>
                <td><strong>Pay Period:</strong> {{ $month }}</td>
            </tr>
        </table>

        <div class="green-box">
            <strong>Employee Net Pay: ₹ {{ number_format($salary, 2) }}</strong><br>
            Paid Days: {{ $paid_days }} | LOP Days: {{ $lop_days }}
        </div>

        <table>
            <thead>
                <tr>
                    <th>Earnings</th>
                    <th>Amount</th>
                    <th>Deductions</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Basic</td>
                    <td>₹ {{ number_format($basic, 2) }}</td>
                    <td>Income Tax</td>
                    <td>₹ {{ number_format($income_tax, 2) }}</td>
                </tr>
                <tr>
                    <td>House Rent Allowance</td>
                    <td>₹ {{ number_format($hra, 2) }}</td>
                    <td>Professional Tax</td>
                    <td>₹ {{ number_format($professional_tax, 2) }}</td>
                </tr>
                <tr>
                    <td>Special Allowances</td>
                    <td>₹ {{ number_format($special_allowance, 2) }}</td>
                    <td>LOP</td>
                    <td>₹ {{ number_format($lop, 2) }}</td>
                </tr>
                <tr>
                    <td>Leave & Travel Allowance</td>
                    <td>₹ {{ number_format($lta, 2) }}</td>
                    <td>Total Deductions</td>
                    <td>₹ {{ number_format($total_deductions, 2) }}</td>
                </tr>
                <tr>
                    <td>Performance Bonus</td>
                    <td>₹ {{ number_format($bonus, 2) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Leave Encashment</td>
                    <td>₹ {{ number_format($leave_encashment, 2) }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><strong>Gross Earnings</strong></td>
                    <td><strong>₹ {{ number_format($gross_earnings, 2) }}</strong></td>
                    <td><strong>Total Deductions</strong></td>
                    <td><strong>₹ {{ number_format($total_deductions, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="green-box">
            <strong>Total Net Payable: ₹ {{ number_format($net_salary, 2) }}</strong>
        </div>

        <p class="note">
            1) As part of our policy, you are requested not to discuss your remuneration with any person.<br>
            2) This is a computer-generated payslip, no signature or stamp is required.<br>
            3) In case of any discrepancy, please revert to the payroll team within 7 days.
        </p>
    </div>
</body>
</html>
