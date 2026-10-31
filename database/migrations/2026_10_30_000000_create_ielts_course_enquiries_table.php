<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ielts_course_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('enquiry_reference', 32)->unique();
            $table->uuid('submission_key')->unique();
            $table->char('retry_token_hash', 64);
            $table->string('name', 100);
            $table->string('email');
            $table->string('phone', 20);
            $table->string('city', 100);
            $table->string('plan_key', 30);
            $table->string('plan_name', 120);
            $table->unsignedInteger('amount');
            $table->char('currency', 3)->default('INR');
            $table->string('payment_status', 20)->default('pending');
            $table->string('razorpay_order_id')->nullable()->unique();
            $table->string('razorpay_payment_id')->nullable()->unique();
            $table->boolean('payment_verified')->default(false);
            $table->timestamp('payment_date')->nullable();
            $table->timestamp('initial_admin_email_sent_at')->nullable();
            $table->timestamp('initial_student_email_sent_at')->nullable();
            $table->timestamp('payment_admin_email_sent_at')->nullable();
            $table->timestamp('payment_student_email_sent_at')->nullable();
            $table->timestamps();
        });

        Schema::create('ielts_course_payment_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ielts_course_enquiry_id')
                ->constrained('ielts_course_enquiries')
                ->cascadeOnDelete();
            $table->string('razorpay_order_id');
            $table->string('razorpay_payment_id')->unique();
            $table->unsignedInteger('amount');
            $table->char('currency', 3);
            $table->string('payment_method', 30)->nullable();
            $table->string('status', 20);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ielts_course_payment_attempts');
        Schema::dropIfExists('ielts_course_enquiries');
    }
};