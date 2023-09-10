<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenjualanDealerKartuPerdana extends Model
{
    use HasFactory;

    protected $table = 'penjualan_dealer_kartu_perdana';

    /**
     * Get the dealer that owns the DealerPulsa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class, 'supplier_id', 'id');
    }
    
    /**
     * Get the dealer that owns the DealerPulsa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function biller(): BelongsTo
    {
        return $this->belongsTo(Biller::class, 'biller_id', 'id');
    }
    
    /**
     * Get the dealer that owns the DealerPulsa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pembelian_bkp(): BelongsTo
    {
        return $this->belongsTo(PembelianBillerKartuPerdana::class, 'pembelian_bkp_id', 'id');
    }
    
    /**
     * Get the supplier_pulsa that owns the DealerPulsa
     *
     * @return BelongsTo
     */
    public function kartu(): BelongsTo
    {
        return $this->belongsTo(Kartu::class, 'kartu_id', 'id');
    }
}
