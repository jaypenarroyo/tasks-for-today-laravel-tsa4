<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Completed Notification</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; background-color: #f8fafc; color: #0f172a; padding: 24px;">
    <div style="max-width: 560px; margin: 0 auto; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden;">
        <div style="background: #2563eb; color: #ffffff; padding: 18px 24px;">
            <h1 style="margin: 0; font-size: 18px;">Task Completed</h1>
        </div>
        <div style="padding: 24px;">
            <p style="margin-top: 0;">The following task in <strong>Tasks for Today</strong> has been marked as <strong>Done</strong>:</p>

            <table style="width: 100%; border-collapse: collapse; margin: 16px 0; font-size: 14px;">
                <tr>
                    <td style="padding: 8px 0; color: #475569; width: 130px;"><strong>Task Title:</strong></td>
                    <td style="padding: 8px 0; color: #0f172a;">{{ $task->title }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #475569;"><strong>Scheduled Date:</strong></td>
                    <td style="padding: 8px 0; color: #0f172a;">{{ $task->task_date->format('F j, Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #475569;"><strong>Status:</strong></td>
                    <td style="padding: 8px 0; color: #15803d; font-weight: 600;">{{ $task->status_label }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #475569;"><strong>Updated At:</strong></td>
                    <td style="padding: 8px 0; color: #0f172a;">{{ $task->updated_at->format('F j, Y g:i A') }}</td>
                </tr>
            </table>

            <p style="margin-bottom: 0; font-size: 13px; color: #64748b;">
                This automated notification was sent by the IT0049 TSA4 Tasks for Today Management System.
            </p>
        </div>
    </div>
</body>
</html>
