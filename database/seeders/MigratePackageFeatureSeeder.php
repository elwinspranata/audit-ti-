<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageFeature;
use Illuminate\Database\Seeder;

class MigratePackageFeatureSeeder extends Seeder
{
    /**
     * Migrate existing package descriptions to package_features table.
     */
    public function run(): void
    {
        $packages = Package::all();

        foreach ($packages as $package) {
            // Skip if features already exist
            if ($package->features()->count() > 0) {
                $this->command->info("Package '{$package->name}' already has features, skipping...");
                continue;
            }

            // Parse description into individual feature lines
            if (!empty($package->description)) {
                $features = explode("\n", $package->description);
                $sortOrder = 0;

                foreach ($features as $feature) {
                    $featureName = trim($feature);
                    if (!empty($featureName)) {
                        PackageFeature::create([
                            'package_id' => $package->id,
                            'feature_name' => $featureName,
                            'is_included' => true,
                            'sort_order' => $sortOrder,
                        ]);
                        $sortOrder++;
                    }
                }

                $this->command->info("Migrated {$sortOrder} features for package '{$package->name}'");
            }

            // Set is_popular for the middle package (level 2) as it was hard-coded before
            if ($package->level == 2) {
                $package->update(['is_popular' => true]);
                $this->command->info("Marked '{$package->name}' as popular");
            }
        }

        $this->command->info('Package feature migration complete!');
    }
}
