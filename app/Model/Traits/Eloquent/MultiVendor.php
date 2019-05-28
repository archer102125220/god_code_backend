<?php

namespace App\Model\Traits\Eloquent;

use App\Model\Eloquent\Vendor;
use Auth;
use Illuminate\Database\Eloquent\Model;
use JWTAuth;

/**
 * Authorization Model Should Have This Trait
 */
trait MultiVendor
{
    protected $userVendorKey = 'vendor_id';
    protected $modelVendorKey = 'vendor_id';

    public function scopeByVendorId($query, $vendorId = null)
    {
        return $query->where($this->modelVendorKey, $vendorId);
    }

    public function isVendor()
    {
        return !is_null($this->getAttribute($this->modelVendorKey));
    }

    public function scopeByVendor($query)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            $user = Auth::user();
        }
        if (!is_null($user)) {
            if ($user->isVendor()) {
                return $this->scopeByVendorId($query, $user->vendor_id);
            } else {
                return $query;
            }
        }
        return $query;
    }

    /**
     * Data can have one vendor
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, $this->modelVendorKey, 'id');
    }

    public function massAssignVendor($vendorId = null)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            $user = Auth::user();
        }
        if (!is_null($user)) {
            if ($user->isVendor()) {
                $this->setAttribute($this->modelVendorKey, $user->vendor_id);
            } else {
                $this->setAttribute($this->modelVendorKey, $vendorId);
            }
        } else {
            $this->setAttribute($this->modelVendorKey, $vendorId);
        }
    }

}
