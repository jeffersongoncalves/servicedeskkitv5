<?php

namespace Database\Seeders;

use App\Models\Operator;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JeffersonGoncalves\ServiceDesk\Models\BusinessHoursSchedule;
use JeffersonGoncalves\ServiceDesk\Models\BusinessHoursTimeSlot;
use JeffersonGoncalves\ServiceDesk\Models\CannedResponse;
use JeffersonGoncalves\ServiceDesk\Models\Category;
use JeffersonGoncalves\ServiceDesk\Models\Department;
use JeffersonGoncalves\ServiceDesk\Models\KbArticle;
use JeffersonGoncalves\ServiceDesk\Models\KbCategory;
use JeffersonGoncalves\ServiceDesk\Models\Service;
use JeffersonGoncalves\ServiceDesk\Models\ServiceCategory;
use JeffersonGoncalves\ServiceDesk\Models\SlaPolicy;
use JeffersonGoncalves\ServiceDesk\Models\SlaTarget;
use JeffersonGoncalves\ServiceDesk\Models\Tag;
use JeffersonGoncalves\ServiceDesk\Models\Ticket;
use JeffersonGoncalves\ServiceDesk\Models\TicketComment;

class ServiceDeskSeeder extends Seeder
{
    public function run(): void
    {
        $operator = Operator::first();
        $user = User::first();

        // Tags
        $tagBug = Tag::create(['name' => 'Bug', 'slug' => 'bug', 'color' => '#ef4444', 'description' => 'Software bug or defect']);
        $tagFeature = Tag::create(['name' => 'Feature Request', 'slug' => 'feature-request', 'color' => '#3b82f6', 'description' => 'New feature request']);
        $tagUrgent = Tag::create(['name' => 'Urgent', 'slug' => 'urgent', 'color' => '#f97316', 'description' => 'Requires immediate attention']);
        $tagNetwork = Tag::create(['name' => 'Network', 'slug' => 'network', 'color' => '#8b5cf6', 'description' => 'Network related issues']);
        $tagHardware = Tag::create(['name' => 'Hardware', 'slug' => 'hardware', 'color' => '#6b7280', 'description' => 'Hardware related issues']);

        // Business Hours Schedule
        $schedule = BusinessHoursSchedule::create([
            'name' => 'Standard Business Hours',
            'description' => 'Monday to Friday, 9AM-6PM',
            'timezone' => 'America/Sao_Paulo',
            'is_default' => true,
            'is_active' => true,
        ]);

        foreach (range(1, 5) as $day) { // Monday=1 to Friday=5
            BusinessHoursTimeSlot::create([
                'schedule_id' => $schedule->id,
                'day_of_week' => $day,
                'start_time' => '09:00',
                'end_time' => '18:00',
            ]);
        }

        // Departments
        $itDept = Department::create([
            'name' => 'IT Support',
            'slug' => 'it-support',
            'description' => 'Information Technology support team',
            'email' => 'it@servicedeskkit.com',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $hrDept = Department::create([
            'name' => 'HR',
            'slug' => 'hr',
            'description' => 'Human Resources department',
            'email' => 'hr@servicedeskkit.com',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $facilitiesDept = Department::create([
            'name' => 'Facilities',
            'slug' => 'facilities',
            'description' => 'Building and facilities management',
            'email' => 'facilities@servicedeskkit.com',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        // Assign operator to departments
        if ($operator) {
            DB::table('service_desk_department_operator')->insert([
                ['department_id' => $itDept->id, 'operator_type' => get_class($operator), 'operator_id' => $operator->id, 'role' => 'agent', 'created_at' => now(), 'updated_at' => now()],
                ['department_id' => $hrDept->id, 'operator_type' => get_class($operator), 'operator_id' => $operator->id, 'role' => 'agent', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // Categories
        $catHardware = Category::create(['department_id' => $itDept->id, 'name' => 'Hardware', 'slug' => 'hardware', 'description' => 'Hardware related issues', 'is_active' => true, 'sort_order' => 1]);
        $catSoftware = Category::create(['department_id' => $itDept->id, 'name' => 'Software', 'slug' => 'software', 'description' => 'Software related issues', 'is_active' => true, 'sort_order' => 2]);
        $catNetwork = Category::create(['department_id' => $itDept->id, 'name' => 'Network', 'slug' => 'network', 'description' => 'Network and connectivity', 'is_active' => true, 'sort_order' => 3]);
        $catOnboarding = Category::create(['department_id' => $hrDept->id, 'name' => 'Onboarding', 'slug' => 'onboarding', 'description' => 'New employee onboarding', 'is_active' => true, 'sort_order' => 1]);
        $catMaintenance = Category::create(['department_id' => $facilitiesDept->id, 'name' => 'Maintenance', 'slug' => 'maintenance', 'description' => 'Building maintenance requests', 'is_active' => true, 'sort_order' => 1]);

        // SLA Policies
        $slaCritical = SlaPolicy::create([
            'name' => 'Critical - 1h Response',
            'description' => 'For critical/urgent issues requiring immediate attention',
            'business_hours_schedule_id' => $schedule->id,
            'conditions' => null,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        SlaTarget::create(['sla_policy_id' => $slaCritical->id, 'priority' => 'urgent', 'first_response_time' => 60, 'next_response_time' => 120, 'resolution_time' => 240]);
        SlaTarget::create(['sla_policy_id' => $slaCritical->id, 'priority' => 'high', 'first_response_time' => 120, 'next_response_time' => 240, 'resolution_time' => 480]);

        $slaStandard = SlaPolicy::create([
            'name' => 'Standard - 4h Response',
            'description' => 'Standard SLA for regular support requests',
            'business_hours_schedule_id' => $schedule->id,
            'conditions' => null,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        SlaTarget::create(['sla_policy_id' => $slaStandard->id, 'priority' => 'medium', 'first_response_time' => 240, 'next_response_time' => 480, 'resolution_time' => 1440]);
        SlaTarget::create(['sla_policy_id' => $slaStandard->id, 'priority' => 'low', 'first_response_time' => 480, 'next_response_time' => 960, 'resolution_time' => 2880]);

        // Canned Responses
        CannedResponse::create(['department_id' => $itDept->id, 'title' => 'Restart Computer', 'body' => 'Please try restarting your computer and let us know if the issue persists. To restart: Start Menu > Power > Restart.', 'is_active' => true, 'sort_order' => 1]);
        CannedResponse::create(['department_id' => $itDept->id, 'title' => 'Clear Browser Cache', 'body' => 'Please clear your browser cache and cookies, then try again. In Chrome: Settings > Privacy > Clear browsing data.', 'is_active' => true, 'sort_order' => 2]);
        CannedResponse::create(['department_id' => $itDept->id, 'title' => 'VPN Connection', 'body' => 'To connect to the VPN, open the VPN client, select the server and click Connect. If you need credentials, please contact IT.', 'is_active' => true, 'sort_order' => 3]);
        CannedResponse::create(['department_id' => null, 'title' => 'Ticket Received', 'body' => 'Thank you for contacting us. Your ticket has been received and assigned to our team. We will get back to you shortly.', 'is_active' => true, 'sort_order' => 1]);
        CannedResponse::create(['department_id' => null, 'title' => 'Request More Information', 'body' => 'Thank you for your report. Could you please provide more details? Screenshots or step-by-step instructions to reproduce the issue would be very helpful.', 'is_active' => true, 'sort_order' => 2]);

        // Tickets
        if ($user && $operator) {
            $ticket1 = Ticket::create([
                'department_id' => $itDept->id,
                'category_id' => $catSoftware->id,
                'user_type' => get_class($user),
                'user_id' => $user->id,
                'assigned_to_type' => get_class($operator),
                'assigned_to_id' => $operator->id,
                'title' => 'Cannot access email after password change',
                'description' => 'After changing my Active Directory password yesterday, I am unable to access my email in Outlook. The error says "Invalid credentials". I have already tried restarting Outlook.',
                'status' => 'in_progress',
                'priority' => 'high',
                'source' => 'web',
                'sla_policy_id' => $slaCritical->id,
            ]);
            $ticket1->tags()->attach([$tagBug->id]);

            TicketComment::create([
                'ticket_id' => $ticket1->id,
                'author_type' => get_class($operator),
                'author_id' => $operator->id,
                'body' => 'Hi! I will check the credential sync between AD and the mail server. Please try again in 15 minutes.',
                'type' => 'reply',
                'is_internal' => false,
            ]);

            $ticket2 = Ticket::create([
                'department_id' => $itDept->id,
                'category_id' => $catNetwork->id,
                'user_type' => get_class($user),
                'user_id' => $user->id,
                'title' => 'Wi-Fi connection drops frequently in meeting room B',
                'description' => 'The Wi-Fi connection in meeting room B on the 3rd floor keeps dropping every 10-15 minutes. This is affecting our video calls.',
                'status' => 'open',
                'priority' => 'medium',
                'source' => 'web',
                'sla_policy_id' => $slaStandard->id,
            ]);
            $ticket2->tags()->attach([$tagNetwork->id]);

            $ticket3 = Ticket::create([
                'department_id' => $itDept->id,
                'category_id' => $catHardware->id,
                'user_type' => get_class($user),
                'user_id' => $user->id,
                'assigned_to_type' => get_class($operator),
                'assigned_to_id' => $operator->id,
                'title' => 'Request new monitor - dual screen setup',
                'description' => 'I would like to request an additional monitor for a dual-screen setup to improve productivity. My current setup only has one 24" monitor.',
                'status' => 'pending',
                'priority' => 'low',
                'source' => 'web',
            ]);
            $ticket3->tags()->attach([$tagFeature->id, $tagHardware->id]);

            $ticket4 = Ticket::create([
                'department_id' => $hrDept->id,
                'category_id' => $catOnboarding->id,
                'user_type' => get_class($user),
                'user_id' => $user->id,
                'title' => 'New employee onboarding - John Smith starting March 1st',
                'description' => 'Please prepare the onboarding package for John Smith who will be starting as a Software Developer on March 1st. He will need: laptop, desk assignment, email account, and access to development tools.',
                'status' => 'open',
                'priority' => 'medium',
                'source' => 'web',
                'sla_policy_id' => $slaStandard->id,
            ]);

            Ticket::create([
                'department_id' => $facilitiesDept->id,
                'category_id' => $catMaintenance->id,
                'user_type' => get_class($user),
                'user_id' => $user->id,
                'assigned_to_type' => get_class($operator),
                'assigned_to_id' => $operator->id,
                'title' => 'Air conditioning not working in office area C',
                'description' => 'The air conditioning unit in office area C (2nd floor) has stopped working. The temperature is uncomfortably high. Please send maintenance as soon as possible.',
                'status' => 'resolved',
                'priority' => 'high',
                'source' => 'web',
                'resolved_at' => now()->subHour(),
            ]);
        }

        // Knowledge Base
        $kbGeneral = KbCategory::create([
            'name' => 'Getting Started',
            'slug' => 'getting-started',
            'description' => 'Essential guides for new users',
            'icon' => 'heroicon-o-rocket-launch',
            'visibility' => 'public',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $kbTroubleshooting = KbCategory::create([
            'name' => 'Troubleshooting',
            'slug' => 'troubleshooting',
            'description' => 'Common issues and solutions',
            'icon' => 'heroicon-o-wrench-screwdriver',
            'visibility' => 'public',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $kbPolicies = KbCategory::create([
            'name' => 'Company Policies',
            'slug' => 'company-policies',
            'description' => 'Internal company policies and procedures',
            'icon' => 'heroicon-o-document-text',
            'visibility' => 'internal',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        if ($operator) {
            KbArticle::create([
                'category_id' => $kbGeneral->id,
                'title' => 'How to Submit a Support Ticket',
                'slug' => 'how-to-submit-support-ticket',
                'content' => '<h2>Submitting a Support Ticket</h2><p>Follow these steps to submit a support ticket:</p><ol><li>Navigate to the <strong>Support</strong> section in the App panel</li><li>Click <strong>Create Ticket</strong></li><li>Select the appropriate <strong>Department</strong> and <strong>Category</strong></li><li>Fill in a descriptive <strong>Title</strong> and <strong>Description</strong></li><li>Set the <strong>Priority</strong> level</li><li>Attach any relevant files</li><li>Click <strong>Submit</strong></li></ol><p>You will receive a confirmation email with your ticket reference number.</p>',
                'excerpt' => 'Learn how to submit a support ticket for quick resolution of your issues.',
                'author_type' => get_class($operator),
                'author_id' => $operator->id,
                'status' => 'published',
                'visibility' => 'public',
                'published_at' => now()->subDays(7),
                'current_version' => 1,
            ]);

            KbArticle::create([
                'category_id' => $kbTroubleshooting->id,
                'title' => 'VPN Connection Issues',
                'slug' => 'vpn-connection-issues',
                'content' => '<h2>Common VPN Issues</h2><h3>Cannot Connect</h3><p>If you cannot connect to the VPN:</p><ul><li>Ensure you have an active internet connection</li><li>Check if the VPN client is up to date</li><li>Try connecting to a different VPN server</li><li>Restart the VPN client</li></ul><h3>Slow Connection</h3><p>If your VPN connection is slow:</p><ul><li>Connect to the nearest VPN server</li><li>Close bandwidth-intensive applications</li><li>Check your base internet speed</li></ul><h3>Frequent Disconnections</h3><p>If the VPN keeps disconnecting:</p><ul><li>Check your Wi-Fi signal strength</li><li>Try using a wired connection</li><li>Disable power saving mode for your network adapter</li></ul>',
                'excerpt' => 'Solutions for common VPN connection problems including connectivity, speed, and disconnection issues.',
                'author_type' => get_class($operator),
                'author_id' => $operator->id,
                'status' => 'published',
                'visibility' => 'public',
                'published_at' => now()->subDays(5),
                'current_version' => 1,
            ]);

            KbArticle::create([
                'category_id' => $kbPolicies->id,
                'title' => 'IT Equipment Policy',
                'slug' => 'it-equipment-policy',
                'content' => '<h2>IT Equipment Policy</h2><p>This policy covers the use and management of company IT equipment.</p><h3>Requesting Equipment</h3><p>All equipment requests must be submitted through the Service Catalog. Requests require manager approval for items over $500.</p><h3>Equipment Care</h3><p>Employees are responsible for the care of assigned equipment. Report any damage or loss immediately through a support ticket.</p><h3>Return Policy</h3><p>All equipment must be returned upon termination of employment or when no longer needed.</p>',
                'excerpt' => 'Guidelines for requesting, using, and returning company IT equipment.',
                'author_type' => get_class($operator),
                'author_id' => $operator->id,
                'status' => 'published',
                'visibility' => 'internal',
                'published_at' => now()->subDays(14),
                'current_version' => 1,
            ]);
        }

        // Service Catalog
        $scatIT = ServiceCategory::create([
            'name' => 'IT Services',
            'slug' => 'it-services',
            'description' => 'Information Technology services and requests',
            'icon' => 'heroicon-o-computer-desktop',
            'visibility' => 'public',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $scatHR = ServiceCategory::create([
            'name' => 'HR Services',
            'slug' => 'hr-services',
            'description' => 'Human Resources services and requests',
            'icon' => 'heroicon-o-users',
            'visibility' => 'public',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Service::create([
            'category_id' => $scatIT->id,
            'department_id' => $itDept->id,
            'sla_policy_id' => $slaStandard->id,
            'name' => 'New Laptop Request',
            'slug' => 'new-laptop-request',
            'description' => 'Request a new laptop for work',
            'long_description' => 'Submit a request for a new laptop. Available options include standard business laptops and developer workstations. Requires manager approval. Expected delivery: 5-10 business days.',
            'icon' => 'heroicon-o-computer-desktop',
            'requires_approval' => true,
            'default_priority' => 'medium',
            'expected_duration_minutes' => 7200,
            'visibility' => 'public',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Service::create([
            'category_id' => $scatIT->id,
            'department_id' => $itDept->id,
            'sla_policy_id' => $slaStandard->id,
            'name' => 'Software Installation',
            'slug' => 'software-installation',
            'description' => 'Request installation of software on your computer',
            'long_description' => 'Request the installation of approved software on your workstation. Please specify the software name and version. Non-standard software may require additional approval.',
            'icon' => 'heroicon-o-arrow-down-tray',
            'requires_approval' => false,
            'default_priority' => 'low',
            'expected_duration_minutes' => 1440,
            'visibility' => 'public',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Service::create([
            'category_id' => $scatIT->id,
            'department_id' => $itDept->id,
            'sla_policy_id' => $slaCritical->id,
            'name' => 'Password Reset',
            'slug' => 'password-reset',
            'description' => 'Reset your account password',
            'long_description' => 'If you are locked out of your account or need a password reset, submit this request. For security verification, you may be contacted by IT.',
            'icon' => 'heroicon-o-key',
            'requires_approval' => false,
            'default_priority' => 'high',
            'expected_duration_minutes' => 60,
            'visibility' => 'public',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        Service::create([
            'category_id' => $scatHR->id,
            'department_id' => $hrDept->id,
            'sla_policy_id' => $slaStandard->id,
            'name' => 'Access Badge Request',
            'slug' => 'access-badge-request',
            'description' => 'Request a new or replacement access badge',
            'long_description' => 'Submit a request for a new access badge or to replace a lost/damaged badge. A photo ID is required for verification.',
            'icon' => 'heroicon-o-identification',
            'requires_approval' => true,
            'default_priority' => 'medium',
            'expected_duration_minutes' => 2880,
            'visibility' => 'public',
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }
}
