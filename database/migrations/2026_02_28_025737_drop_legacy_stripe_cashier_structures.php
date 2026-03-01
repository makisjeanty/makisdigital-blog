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
        if (Schema::hasTable('subscription_items')) {
            Schema::drop('subscription_items');
        }

        if (Schema::hasTable('subscriptions')) {
            Schema::drop('subscriptions');
        }

        if (Schema::hasTable('courses')) {
            Schema::table('courses', function (Blueprint $table) {
                if (Schema::hasColumn('courses', 'stripe_product_id')) {
                    $table->dropColumn('stripe_product_id');
                }
                if (Schema::hasColumn('courses', 'stripe_price_id')) {
                    $table->dropColumn('stripe_price_id');
                }
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'stripe_id')) {
                    if (Schema::hasIndex('users', 'users_stripe_id_index')) {
                        $table->dropIndex('users_stripe_id_index');
                    }
                    $table->dropColumn('stripe_id');
                }
                if (Schema::hasColumn('users', 'pm_type')) {
                    $table->dropColumn('pm_type');
                }
                if (Schema::hasColumn('users', 'pm_last_four')) {
                    $table->dropColumn('pm_last_four');
                }
                if (Schema::hasColumn('users', 'trial_ends_at')) {
                    $table->dropColumn('trial_ends_at');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('subscriptions')) {
            Schema::create('subscriptions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('type');
                $table->string('stripe_id')->unique();
                $table->string('stripe_status');
                $table->string('stripe_price')->nullable();
                $table->integer('quantity')->nullable();
                $table->timestamp('trial_ends_at')->nullable();
                $table->timestamp('ends_at')->nullable();
                $table->timestamps();

                $table->index(['user_id', 'stripe_status']);
            });
        }

        if (! Schema::hasTable('subscription_items')) {
            Schema::create('subscription_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('subscription_id')->constrained('subscriptions')->cascadeOnDelete();
                $table->string('stripe_id')->unique();
                $table->string('stripe_product');
                $table->string('stripe_price');
                $table->integer('quantity')->nullable();
                $table->string('meter_id')->nullable();
                $table->string('meter_event_name')->nullable();
                $table->timestamps();

                $table->index(['subscription_id', 'stripe_price']);
            });
        }

        if (Schema::hasTable('courses')) {
            Schema::table('courses', function (Blueprint $table) {
                if (! Schema::hasColumn('courses', 'stripe_product_id')) {
                    $table->string('stripe_product_id')->nullable()->after('status');
                }
                if (! Schema::hasColumn('courses', 'stripe_price_id')) {
                    $table->string('stripe_price_id')->nullable()->after('stripe_product_id');
                }
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (! Schema::hasColumn('users', 'stripe_id')) {
                    $table->string('stripe_id')->nullable()->index();
                }
                if (! Schema::hasColumn('users', 'pm_type')) {
                    $table->string('pm_type')->nullable();
                }
                if (! Schema::hasColumn('users', 'pm_last_four')) {
                    $table->string('pm_last_four', 4)->nullable();
                }
                if (! Schema::hasColumn('users', 'trial_ends_at')) {
                    $table->timestamp('trial_ends_at')->nullable();
                }
            });
        }
    }
};
