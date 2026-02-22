<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('audit_reports', function (Blueprint $table) {
            // Report Header Info
            $table->string('report_title')->nullable()->after('id');
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('sign_off_authority')->nullable();
            
            // Internal Audit Contacts
            $table->string('audit_director')->nullable();
            $table->string('audit_director_phone')->nullable();
            $table->string('audit_manager')->nullable();
            $table->string('audit_manager_phone')->nullable();
            $table->string('lead_auditor_name')->nullable();
            $table->string('lead_auditor_phone')->nullable();
            
            // Maturity Rating
            $table->string('maturity_rating_actual')->nullable();
            $table->string('maturity_rating_target')->nullable();
            
            // Issue Priorities Count
            $table->integer('issues_priority_a')->default(0);
            $table->integer('issues_priority_b')->default(0);
            $table->integer('issues_priority_c')->default(0);
            
            // Detailed Observations Count
            $table->integer('observations_optimized')->default(0);
            $table->integer('observations_managed')->default(0);
            $table->integer('observations_defined')->default(0);
            $table->integer('observations_repeatable')->default(0);
            $table->integer('observations_initial')->default(0);
            
            // Prior Audit Reference
            $table->string('prior_audit_name')->nullable();
            $table->date('prior_audit_date')->nullable();
            
            // Responsible Officer Response
            $table->string('officer_name')->nullable();
            $table->string('officer_title')->nullable();
            $table->text('officer_response')->nullable();
            $table->date('officer_response_date')->nullable();
            
            // JSON fields for complex data
            $table->json('reportable_issues')->nullable(); // Array of issues with control weakness, priority, corrective action, due date
            $table->json('strategic_focal_points')->nullable(); // By COBIT High-Level Objective
            $table->json('it_process_focal_points')->nullable(); // By COBIT Detailed Control Objective
            $table->json('control_focal_points')->nullable(); // Control details
            $table->json('distribution_list')->nullable(); // Client names for distribution
            
            // Workflow diagram (optional file path or description)
            $table->text('workflow_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audit_reports', function (Blueprint $table) {
            $table->dropColumn([
                'report_title',
                'company_name',
                'company_address',
                'sign_off_authority',
                'audit_director',
                'audit_director_phone',
                'audit_manager',
                'audit_manager_phone',
                'lead_auditor_name',
                'lead_auditor_phone',
                'maturity_rating_actual',
                'maturity_rating_target',
                'issues_priority_a',
                'issues_priority_b',
                'issues_priority_c',
                'observations_optimized',
                'observations_managed',
                'observations_defined',
                'observations_repeatable',
                'observations_initial',
                'prior_audit_name',
                'prior_audit_date',
                'officer_name',
                'officer_title',
                'officer_response',
                'officer_response_date',
                'reportable_issues',
                'strategic_focal_points',
                'it_process_focal_points',
                'control_focal_points',
                'distribution_list',
                'workflow_description',
            ]);
        });
    }
};
