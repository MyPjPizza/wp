<?php
/**
 * AffiliateWP related functions used within plugin.
 *
 * @since 1.0.0
 * @package GeoDir_Affiliate
 */
class Affiliate_WP_GeoDirectory extends Affiliate_WP_Base {
	/**
	 * Array of payment completed status.
	 *
	 * @access  public
	 * @since   1.0.0
	 */
	public $paid_status;
	
	/**
	 * Gets things started.
	 *
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function init() {
		$this->context = 'geodirectory';
		$this->paid_status = array( 'paid', 'active', 'subscription-payment' );
		
		add_action( 'geodir_payment_invoice_created', array( $this, 'add_pending_referral' ), 10, 2 );
		add_action( 'geodir_payment_invoice_status_changed', array( $this, 'mark_referral_complete' ), 10 );
		add_action( 'geodir_payment_invoice_status_changed', array( $this, 'revoke_referral_on_refund' ), 10 );
		
		add_filter( 'affwp_referral_reference_column', array( $this, 'reference_link' ), 10, 2 );
	}

	/**
	 * Records a pending referral when a pending payment is created.
	 *
	 * @access  public
	 * @since   1.0.0
	 *
	 * @param  int $invoice_id The reference id the referral.
	 * @return void
	 */
	public function add_pending_referral( $invoice_id = 0 ) {
		if ( $this->was_referred() ) {
			if ( !(int)$invoice_id > 0 ) {
				return; // Invalid invoice id
			}
				
			$invoice = geodir_get_invoice( $invoice_id );
			if ( empty( $invoice ) ) {
				return; // Invalid invoice
			}
			
			$user = get_userdata( $invoice->user_id );
			if( !empty( $user ) && $this->get_affiliate_email() == $user->user_email ) {
				return; // Customers cannot refer themselves
			}
			
			$reference = $invoice->id;
			
			if( affiliate_wp()->referrals->get_by( 'reference', $reference, $this->context ) ) {
				return; // Referral already created for this reference
			}
			
			$amount = (float)$invoice->paied_amount;
			
			if ( !$amount > 0 ) {
				return; // Paid amount is not vaild
			}
			
			$description = wp_sprintf( __( 'GeoDirectory : %s', 'gdaffiliate' ), $invoice->package_title );
			
			$referral_total = $this->calculate_referral_amount( $amount, $reference );
			
			// Add referral
			$referral_id = $this->insert_pending_referral( $referral_total, $reference, $description );
			
			if ( in_array( geodir_strtolower( $invoice->status ), $this->paid_status ) ) {
				if( $referral_id ) {
					affiliate_wp()->referrals->update( $referral_id, array( 'affiliate_id' => $this->affiliate_id, 'referral_id' => $referral_id, 'status' => 'paid', 'amount' => $referral_total, 'custom' => $reference ), '', 'referral' );
				}
				
				// Add referral
				$this->complete_referral( $reference );
			}
		}
	}
	
	/**
	 * Sets a referral to unpaid when payment is completed.
	 *
	 * @access  public
	 * @since   1.0.0
	 *
	 * @param int    $invoice_id The reference invoice id for the referral to complete per the current context.
	 * @param string $status Status fo the payment invoice. Optional.
	 */
	public function mark_referral_complete( $invoice_id = 0, $status = '' ) {
		if ( !(int)$invoice_id > 0 ) {
			return; // Invalid invoice id
		}
			
		$invoice = geodir_get_invoice( $invoice_id );

		if ( empty( $invoice ) ) {
			return; // Invalid invoice
		}
		
		$payment_status = geodir_strtolower( $invoice->status );
		
		if ( $status != '' && $status == $payment_status ) {
			return; // No status change
		}
		
		if ( in_array( $payment_status, $this->paid_status ) ) {
			$this->complete_referral( $invoice_id );
		}
	}
	
	/**
	 * Revokes a referral when payment is refunded
	 *
	 * @access  public
	 * @since   1.0.0
	 *
	 * @param int    $invoice_id The reference invoice id for the referral to refund per the current context.
	 * @param string $status Status fo the payment invoice. Optional.
	 */
	public function revoke_referral_on_refund( $invoice_id = 0, $status = '' ) {
		if( !affiliate_wp()->settings->get( 'revoke_on_refund' ) ) {
			return;
		}

		if ( !(int)$invoice_id > 0 ) {
			return; // Invalid invoice id
		}
			
		$invoice = geodir_get_invoice( $invoice_id );
		
		if ( empty( $invoice ) ) {
			return; // Invalid invoice
		}
		
		$payment_status = geodir_strtolower( $invoice->status );
		
		if ( !in_array( $payment_status, $this->paid_status ) ) {
			$this->reject_referral( $invoice_id );
		}
	}
	
	/**
	 * Builds the reference link for the referrals table
	 *
	 * @access  public
	 * @since   1.0.0
	 *
	 * @param int    $reference The reference column for the referral for the current context.
	 * @param object $referral The referral object data.
	 * @return string Html text link.
	 */
	public function reference_link( $reference = 0, $referral ) {
		if( empty( $referral->context ) || $this->context != $referral->context ) {
			return $reference;
		}

		$url = admin_url( 'admin.php?page=geodirectory&tab=paymentmanager_fields&subtab=geodir_invoice_list&invoice_id=' . $reference );

		return '<a href="' . esc_url( $url ) . '">' . $reference . '</a>';
	}
}
new Affiliate_WP_GeoDirectory;
