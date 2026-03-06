<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Illuminate\Support\Facades\Log;

class MailService
{
    /**
     * Send an email using PHPMailer.
     *
     * @param string $toEmail
     * @param string $toName
     * @param string $subject
     * @param string $htmlBody
     * @return bool
     */
    public static function send(string $toEmail, string $toName, string $subject, string $htmlBody): bool
    {
        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = config('mail.mailers.smtp.host');
            $mail->SMTPAuth   = true;
            $mail->Username   = config('mail.mailers.smtp.username');
            $mail->Password   = config('mail.mailers.smtp.password');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = config('mail.mailers.smtp.port');

            // Recipients
            $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
            $mail->addAddress($toEmail, $toName);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $htmlBody;

            $mail->send();
            return true;
        } catch (\Exception $e) {
            Log::error('Mailer error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Email template: Pending Approval (to officials)
     *
     * @param string $residentName
     * @param string $residentEmail
     * @param string $approvalLink
     * @return string
     */
    public static function pendingApprovalEmail(string $residentName, string $residentEmail, string $approvalLink): string
    {
        $currentDateTime = now()->format('F j, Y g:i A');
        
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: \'Segoe UI\', Tahoma, sans-serif; background-color: #f0f9ff;">
            <div style="background: linear-gradient(135deg, #1a6fcc 0%, #3a8a3f 100%); padding: 32px; text-align: center;">
                <div style="font-size: 40px; margin-bottom: 8px;">🏛️</div>
                <div style="color: white; font-size: 22px; font-weight: bold; margin-bottom: 4px;">Barangay Management System</div>
                <div style="color: rgba(255, 255, 255, 0.7); font-size: 13px;">Official Communication</div>
            </div>
            
            <div style="background: white; border-radius: 12px; padding: 40px; margin: 24px auto; max-width: 560px; box-shadow: 0 4px 20px rgba(26, 111, 204, 0.1);">
                <h2 style="color: #1a6fcc; margin-top: 0; margin-bottom: 24px; font-size: 24px;">New Resident Registration Pending Approval</h2>
                
                <p style="color: #2c3e50; font-size: 15px; line-height: 1.6; margin-bottom: 24px;">
                    A new resident has registered and is awaiting approval. Please review their information below:
                </p>
                
                <div style="background: #f8fafc; border-left: 4px solid #1a6fcc; padding: 16px; margin-bottom: 24px; border-radius: 4px;">
                    <div style="margin-bottom: 8px;">
                        <strong style="color: #1a6fcc;">Resident Name:</strong> 
                        <span style="color: #2c3e50;">' . htmlspecialchars($residentName) . '</span>
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong style="color: #1a6fcc;">Email Address:</strong> 
                        <span style="color: #2c3e50;">' . htmlspecialchars($residentEmail) . '</span>
                    </div>
                    <div>
                        <strong style="color: #1a6fcc;">Registration Date:</strong> 
                        <span style="color: #2c3e50;">' . $currentDateTime . '</span>
                    </div>
                </div>
                
                <p style="color: #2c3e50; font-size: 15px; line-height: 1.6; margin-bottom: 28px;">
                    Please review this registration request and take appropriate action.
                </p>
                
                <div style="text-align: center;">
                    <a href="' . htmlspecialchars($approvalLink) . '" style="background: #3a8a3f; color: white; border-radius: 8px; padding: 14px 32px; font-weight: 700; text-decoration: none; display: inline-block; font-size: 15px;">
                        Review Pending Request
                    </a>
                </div>
            </div>
            
            <div style="background: #daf0fa; padding: 20px; text-align: center; font-size: 12px; color: #5a7a9a;">
                This is an automated message from Barangay Management System
            </div>
        </body>
        </html>
        ';
    }

    /**
     * Email template: Account Approved
     *
     * @param string $residentName
     * @param string $loginLink
     * @return string
     */
    public static function accountApprovedEmail(string $residentName, string $loginLink): string
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: \'Segoe UI\', Tahoma, sans-serif; background-color: #f0f9ff;">
            <div style="background: linear-gradient(135deg, #1a6fcc 0%, #3a8a3f 100%); padding: 32px; text-align: center;">
                <div style="font-size: 40px; margin-bottom: 8px;">🏛️</div>
                <div style="color: white; font-size: 22px; font-weight: bold; margin-bottom: 4px;">Barangay Management System</div>
                <div style="color: rgba(255, 255, 255, 0.7); font-size: 13px;">Official Communication</div>
            </div>
            
            <div style="background: white; border-radius: 12px; padding: 40px; margin: 24px auto; max-width: 560px; box-shadow: 0 4px 20px rgba(26, 111, 204, 0.1);">
                <div style="text-align: center; margin-bottom: 24px;">
                    <div style="display: inline-block; background: #d1fae5; border-radius: 50%; width: 64px; height: 64px; line-height: 64px; font-size: 36px;">✅</div>
                </div>
                
                <h2 style="color: #3a8a3f; margin-top: 0; margin-bottom: 24px; font-size: 24px; text-align: center;">Account Approved!</h2>
                
                <p style="color: #2c3e50; font-size: 15px; line-height: 1.6; margin-bottom: 20px;">
                    Dear <strong>' . htmlspecialchars($residentName) . '</strong>,
                </p>
                
                <p style="color: #2c3e50; font-size: 15px; line-height: 1.6; margin-bottom: 24px;">
                    Congratulations! Your account has been approved by the barangay officials. You can now access all resident services and features in the Barangay Management System.
                </p>
                
                <div style="background: #f0fdf4; border-left: 4px solid #3a8a3f; padding: 16px; margin-bottom: 28px; border-radius: 4px;">
                    <p style="color: #15803d; margin: 0; font-size: 14px; line-height: 1.6;">
                        🎉 You now have full access to:
                    </p>
                    <ul style="color: #15803d; margin: 8px 0 0 0; padding-left: 20px;">
                        <li style="margin-bottom: 4px;">Your resident dashboard</li>
                        <li style="margin-bottom: 4px;">Online barangay ID</li>
                        <li style="margin-bottom: 4px;">Document requests</li>
                        <li>Official notifications</li>
                    </ul>
                </div>
                
                <div style="text-align: center;">
                    <a href="' . htmlspecialchars($loginLink) . '" style="background: #3a8a3f; color: white; border-radius: 8px; padding: 14px 32px; font-weight: 700; text-decoration: none; display: inline-block; font-size: 15px;">
                        Log In Now
                    </a>
                </div>
            </div>
            
            <div style="background: #daf0fa; padding: 20px; text-align: center; font-size: 12px; color: #5a7a9a;">
                This is an automated message from Barangay Management System
            </div>
        </body>
        </html>
        ';
    }

    /**
     * Email template: Account Rejected
     *
     * @param string $residentName
     * @return string
     */
    public static function accountRejectedEmail(string $residentName): string
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: \'Segoe UI\', Tahoma, sans-serif; background-color: #f0f9ff;">
            <div style="background: linear-gradient(135deg, #1a6fcc 0%, #3a8a3f 100%); padding: 32px; text-align: center;">
                <div style="font-size: 40px; margin-bottom: 8px;">🏛️</div>
                <div style="color: white; font-size: 22px; font-weight: bold; margin-bottom: 4px;">Barangay Management System</div>
                <div style="color: rgba(255, 255, 255, 0.7); font-size: 13px;">Official Communication</div>
            </div>
            
            <div style="background: white; border-radius: 12px; padding: 40px; margin: 24px auto; max-width: 560px; box-shadow: 0 4px 20px rgba(26, 111, 204, 0.1);">
                <h2 style="color: #dc2626; margin-top: 0; margin-bottom: 24px; font-size: 24px;">Registration Status Update</h2>
                
                <p style="color: #2c3e50; font-size: 15px; line-height: 1.6; margin-bottom: 20px;">
                    Dear <strong>' . htmlspecialchars($residentName) . '</strong>,
                </p>
                
                <p style="color: #2c3e50; font-size: 15px; line-height: 1.6; margin-bottom: 24px;">
                    We regret to inform you that your registration request for the Barangay Management System could not be approved at this time.
                </p>
                
                <div style="background: #fef2f2; border-left: 4px solid #dc2626; padding: 16px; margin-bottom: 24px; border-radius: 4px;">
                    <p style="color: #991b1b; margin: 0; font-size: 14px; line-height: 1.6;">
                        This may be due to incomplete information or verification issues. We encourage you to visit the barangay office in person for assistance.
                    </p>
                </div>
                
                <p style="color: #2c3e50; font-size: 15px; line-height: 1.6; margin-bottom: 24px;">
                    If you believe this decision was made in error or if you have any questions, please contact the barangay office directly during office hours.
                </p>
                
                <div style="background: #f8fafc; padding: 16px; border-radius: 4px; margin-bottom: 20px;">
                    <p style="color: #475569; margin: 0 0 8px 0; font-size: 13px; font-weight: 600;">Barangay Office Contact Information:</p>
                    <p style="color: #64748b; margin: 0; font-size: 13px; line-height: 1.6;">
                        📍 Visit us during office hours<br>
                        📞 Contact your local barangay office<br>
                        ✉️ Bring valid identification documents
                    </p>
                </div>
                
                <p style="color: #64748b; font-size: 13px; line-height: 1.6; margin: 0; text-align: center;">
                    We appreciate your understanding.
                </p>
            </div>
            
            <div style="background: #daf0fa; padding: 20px; text-align: center; font-size: 12px; color: #5a7a9a;">
                This is an automated message from Barangay Management System
            </div>
        </body>
        </html>
        ';
    }

    /**
     * Email template: Account Created by Official
     *
     * @param string $residentName
     * @param string $email
     * @param string $tempPassword
     * @param string $loginLink
     * @return string
     */
    public static function accountCreatedByOfficialEmail(string $residentName, string $email, string $tempPassword, string $loginLink): string
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: \'Segoe UI\', Tahoma, sans-serif; background-color: #f0f9ff;">
            <div style="background: linear-gradient(135deg, #1a6fcc 0%, #3a8a3f 100%); padding: 32px; text-align: center;">
                <div style="font-size: 40px; margin-bottom: 8px;">🏛️</div>
                <div style="color: white; font-size: 22px; font-weight: bold; margin-bottom: 4px;">Barangay Management System</div>
                <div style="color: rgba(255, 255, 255, 0.7); font-size: 13px;">Official Communication</div>
            </div>
            
            <div style="background: white; border-radius: 12px; padding: 40px; margin: 24px auto; max-width: 560px; box-shadow: 0 4px 20px rgba(26, 111, 204, 0.1);">
                <h2 style="color: #1a6fcc; margin-top: 0; margin-bottom: 24px; font-size: 24px;">Welcome to Barangay Management System</h2>
                
                <p style="color: #2c3e50; font-size: 15px; line-height: 1.6; margin-bottom: 20px;">
                    Dear <strong>' . htmlspecialchars($residentName) . '</strong>,
                </p>
                
                <p style="color: #2c3e50; font-size: 15px; line-height: 1.6; margin-bottom: 24px;">
                    Your Barangay resident account has been created by a Barangay Official. You can now access the system using the credentials below:
                </p>
                
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; padding: 20px; margin-bottom: 20px; border-radius: 8px;">
                    <div style="margin-bottom: 12px;">
                        <div style="color: #1e40af; font-size: 12px; font-weight: 600; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Email Address</div>
                        <div style="color: #1e3a8a; font-size: 15px; font-family: \'Courier New\', monospace; font-weight: 600;">' . htmlspecialchars($email) . '</div>
                    </div>
                    <div>
                        <div style="color: #1e40af; font-size: 12px; font-weight: 600; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Temporary Password</div>
                        <div style="color: #1e3a8a; font-size: 15px; font-family: \'Courier New\', monospace; font-weight: 600;">' . htmlspecialchars($tempPassword) . '</div>
                    </div>
                </div>
                
                <div style="background: #fffbeb; border-left: 4px solid #f59e0b; padding: 16px; margin-bottom: 28px; border-radius: 4px;">
                    <p style="color: #92400e; margin: 0; font-size: 14px; line-height: 1.6;">
                        ⚠️ <strong>Important Security Notice:</strong><br>
                        Please change your temporary password immediately after logging in for the first time. Choose a strong password to keep your account secure.
                    </p>
                </div>
                
                <p style="color: #2c3e50; font-size: 15px; line-height: 1.6; margin-bottom: 28px;">
                    Once you log in, you will have access to your dashboard, online barangay ID, document requests, and official notifications.
                </p>
                
                <div style="text-align: center;">
                    <a href="' . htmlspecialchars($loginLink) . '" style="background: #3a8a3f; color: white; border-radius: 8px; padding: 14px 32px; font-weight: 700; text-decoration: none; display: inline-block; font-size: 15px;">
                        Log In Now
                    </a>
                </div>
            </div>
            
            <div style="background: #daf0fa; padding: 20px; text-align: center; font-size: 12px; color: #5a7a9a;">
                This is an automated message from Barangay Management System
            </div>
        </body>
        </html>
        ';
    }

    /**
     * Email template: New Notification
     *
     * @param string $residentName
     * @param string $title
     * @param string $message
     * @return string
     */
    public static function newNotificationEmail(string $residentName, string $title, string $message): string
    {
        $portalLink = url('/resident/notifications');
        
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: \'Segoe UI\', Tahoma, sans-serif; background-color: #f0f9ff;">
            <div style="background: linear-gradient(135deg, #1a6fcc 0%, #3a8a3f 100%); padding: 32px; text-align: center;">
                <div style="font-size: 40px; margin-bottom: 8px;">🏛️</div>
                <div style="color: white; font-size: 22px; font-weight: bold; margin-bottom: 4px;">Barangay Management System</div>
                <div style="color: rgba(255, 255, 255, 0.7); font-size: 13px;">Official Communication</div>
            </div>
            
            <div style="background: white; border-radius: 12px; padding: 40px; margin: 24px auto; max-width: 560px; box-shadow: 0 4px 20px rgba(26, 111, 204, 0.1);">
                <div style="text-align: center; margin-bottom: 20px;">
                    <span style="font-size: 48px;">🔔</span>
                </div>
                
                <h2 style="color: #2c3e50; margin-top: 0; margin-bottom: 20px; font-size: 20px; text-align: center;">New Notification</h2>
                
                <p style="color: #2c3e50; font-size: 15px; line-height: 1.6; margin-bottom: 24px;">
                    Hello <strong>' . htmlspecialchars($residentName) . '</strong>,
                </p>
                
                <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                    You have received a new notification from the Barangay Management System:
                </p>
                
                <div style="background: #f8fafc; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
                    <h3 style="color: #1a6fcc; margin: 0 0 12px 0; font-size: 18px; font-weight: 700;">
                        ' . htmlspecialchars($title) . '
                    </h3>
                    <div style="color: #475569; font-size: 15px; line-height: 1.7;">
                        ' . nl2br(htmlspecialchars($message)) . '
                    </div>
                </div>
                
                <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 28px;">
                    For more details and to view all your notifications, please log in to your resident portal.
                </p>
                
                <div style="text-align: center;">
                    <a href="' . htmlspecialchars($portalLink) . '" style="background: #3a8a3f; color: white; border-radius: 8px; padding: 14px 32px; font-weight: 700; text-decoration: none; display: inline-block; font-size: 15px;">
                        View in Portal
                    </a>
                </div>
            </div>
            
            <div style="background: #daf0fa; padding: 20px; text-align: center; font-size: 12px; color: #5a7a9a;">
                This is an automated message from Barangay Management System
            </div>
        </body>
        </html>
        ';
    }

    /**
     * Email template: Email Verification for Officials
     *
     * @param string $officialName
     * @param string $verificationLink
     * @return string
     */
    public static function officialEmailVerification(string $officialName, string $verificationLink): string
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: \'Segoe UI\', Tahoma, sans-serif; background-color: #f8f9fa;">
            <div style="background: #2c3e50; padding: 40px; text-align: center;">
                <div style="color: white; font-size: 28px; font-weight: 600; margin-bottom: 8px;">Barangay Management System</div>
                <div style="color: rgba(255, 255, 255, 0.7); font-size: 14px;">Email Verification Required</div>
            </div>
            
            <div style="background: white; border-radius: 8px; padding: 40px; margin: 24px auto; max-width: 560px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
                <h2 style="color: #1a1a1a; margin-top: 0; margin-bottom: 24px; font-size: 22px; font-weight: 600;">Verify Your Email Address</h2>
                
                <p style="color: #666666; font-size: 15px; line-height: 1.6; margin-bottom: 24px;">
                    Hello <strong>' . htmlspecialchars($officialName) . '</strong>,
                </p>
                
                <p style="color: #666666; font-size: 15px; line-height: 1.6; margin-bottom: 32px;">
                    Your official account has been created. To activate your account and gain access to the Barangay Management System, please verify your email address by clicking the button below.
                </p>
                
                <div style="text-align: center; margin-bottom: 32px;">
                    <a href="' . htmlspecialchars($verificationLink) . '" style="background: #3498db; color: white; border-radius: 6px; padding: 12px 32px; font-weight: 500; text-decoration: none; display: inline-block; font-size: 15px;">
                        Verify Email Address
                    </a>
                </div>
                
                <p style="color: #999999; font-size: 13px; line-height: 1.6; margin-bottom: 24px; text-align: center;">
                    Or copy and paste this link in your browser:<br>
                    <span style="color: #3498db; word-break: break-all;">' . htmlspecialchars($verificationLink) . '</span>
                </p>
                
                <div style="border-top: 1px solid #e0e0e0; padding-top: 24px;">
                    <p style="color: #999999; font-size: 12px; line-height: 1.6; margin: 0;">
                        This link will expire in 24 hours. If you did not create this account, please ignore this email or contact your administrator.
                    </p>
                </div>
            </div>
            
            <div style="background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #999999;">
                Barangay Management System
            </div>
        </body>
        </html>
        ';
    }

    /**
     * Email template: Modern Account Approved Notification
     *
     * @param string $residentName
     * @param string $loginLink
     * @return string
     */
    public static function modernAccountApprovedEmail(string $residentName, string $loginLink): string
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: \'Segoe UI\', Tahoma, sans-serif; background-color: #f8f9fa;">
            <div style="background: #2c3e50; padding: 40px; text-align: center;">
                <div style="color: white; font-size: 28px; font-weight: 600; margin-bottom: 8px;">Barangay Management System</div>
                <div style="color: rgba(255, 255, 255, 0.7); font-size: 14px;">Account Approved</div>
            </div>
            
            <div style="background: white; border-radius: 8px; padding: 40px; margin: 24px auto; max-width: 560px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
                <div style="text-align: center; margin-bottom: 32px;">
                    <div style="display: inline-block; background: #e8f5e9; border-radius: 50%; width: 72px; height: 72px; line-height: 72px; font-size: 40px; color: #27ae60;">✓</div>
                </div>
                
                <h2 style="color: #27ae60; margin-top: 0; margin-bottom: 24px; font-size: 24px; font-weight: 600; text-align: center;">Account Approved</h2>
                
                <p style="color: #666666; font-size: 15px; line-height: 1.6; margin-bottom: 24px;">
                    Hello <strong>' . htmlspecialchars($residentName) . '</strong>,
                </p>
                
                <p style="color: #666666; font-size: 15px; line-height: 1.6; margin-bottom: 32px;">
                    Your resident account has been approved by the barangay officials. You now have full access to all features in the Barangay Management System.
                </p>
                
                <div style="background: #f8f9fa; border-left: 4px solid #27ae60; padding: 20px; margin-bottom: 32px; border-radius: 4px;">
                    <p style="color: #1a1a1a; margin: 0 0 12px 0; font-weight: 600; font-size: 14px;">You can now access:</p>
                    <ul style="color: #666666; margin: 8px 0 0 0; padding-left: 20px; font-size: 14px;">
                        <li style="margin-bottom: 6px;">Your resident dashboard</li>
                        <li style="margin-bottom: 6px;">Online barangay ID</li>
                        <li>View official announcements</li>
                    </ul>
                </div>
                
                <div style="text-align: center;">
                    <a href="' . htmlspecialchars($loginLink) . '" style="background: #3498db; color: white; border-radius: 6px; padding: 12px 32px; font-weight: 500; text-decoration: none; display: inline-block; font-size: 15px;">
                        Log In to Dashboard
                    </a>
                </div>
            </div>
            
            <div style="background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #999999;">
                Barangay Management System
            </div>
        </body>
        </html>
        ';
    }
}
