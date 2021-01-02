<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Wpsipd
 * @subpackage Wpsipd/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wpsipd
 * @subpackage Wpsipd/public
 * @author     Agus Nurwanto <agusnurwantomuslim@gmail.com>
 */
class Wpsipd_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpsipd_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpsipd_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wpsipd-public.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . 'bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpsipd_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpsipd_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wpsipd-public.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name . 'bootstrap', plugin_dir_url(__FILE__) . 'js/bootstrap.bundle.min.js', array('jquery'), $this->version, false);
	}

	public function singkron_ssh($value = '')
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil export SSH!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == APIKEY) {
				if (!empty($_POST['ssh'])) {
					$ssh = $_POST['ssh'];
					foreach ($ssh as $k => $v) {
						$cek = $wpdb->get_var("SELECT id_standar_harga from data_ssh where tahun_anggaran=".$_POST['tahun_anggaran']." AND id_standar_harga=" . $v['id_standar_harga']);
						$kelompok = explode(' ', $v['nama_kel_standar_harga']);
						$opsi = $v + array(
							'nama_kel_standar_harga' => $kelompok[1],
							'update_at'	=> current_time('mysql'),
							'tahun_anggaran'	=> $_POST['tahun_anggaran']
						);
						if (!empty($cek)) {
							$wpdb->update('data_ssh', $opsi, array(
								'tahun_anggaran'	=> $_POST['tahun_anggaran'],
								'id_standar_harga' => $v['id_standar_harga']
							));
						} else {
							$wpdb->insert('data_ssh', $opsi);
						}

						foreach ($v['kd_belanja'] as $key => $value) {
							$cek = $wpdb->get_var("
								SELECT 
									id_standar_harga 
								from data_ssh_rek_belanja 
								where tahun_anggaran=".$_POST['tahun_anggaran']." 
									and id_akun=" . $value['id_akun'] . ' 
									and id_standar_harga=' . $v['id_standar_harga']
							);
							$opsi = array(
								"id_akun"	=> $value['id_akun'],
								"kode_akun" => $value['kode_akun'],
								"nama_akun"	=> $value['nama_akun'],
								"id_standar_harga"	=> $v['id_standar_harga'],
								"tahun_anggaran"	=> $_POST['tahun_anggaran']
							);
							if (!empty($cek)) {
								$wpdb->update('data_ssh_rek_belanja', $opsi, array(
									'id_standar_harga' => $v['id_standar_harga'],
									'id_akun' => $value['id_akun'],
									"tahun_anggaran"	=> $_POST['tahun_anggaran']
								));
							} else {
								$wpdb->insert('data_ssh_rek_belanja', $opsi);
							}
						}
					}
					// print_r($ssh); die();
				} else {
					$ret['status'] = 'error';
					$ret['message'] = 'Format SSH Salah!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		}
		die(json_encode($ret));
	}

	public function datassh($atts)
	{
		$a = shortcode_atts(array(
			'filter' => '',
		), $atts);
		global $wpdb;

		$where = '';
		if (!empty($a['filter'])) {
			if ($a['filter'] == 'is_deleted') {
				$where = 'where is_deleted=1';
			}
		}
		$data_ssh = $wpdb->get_results("SELECT * from data_ssh " . $where, ARRAY_A);
		$tbody = '';
		$no = 1;
		foreach ($data_ssh as $k => $v) {
			// if($k >= 10){ continue; }
			$data_rek = $wpdb->get_results("SELECT * from data_ssh_rek_belanja where id_standar_harga=" . $v['id_standar_harga'], ARRAY_A);
			$rek = array();
			foreach ($data_rek as $key => $value) {
				$rek[] = $value['nama_akun'];
			}
			if (!empty($a['filter'])) {
				if ($a['filter'] == 'rek_kosong' && !empty($rek)) {
					continue;
				}
			}

			$kelompok = "";
			if ($v['kelompok'] == 1) {
				$kelompok = 'SSH';
			}
			$tbody .= '
				<tr>
					<td class="text-center">' . number_format($no, 0, ",", ".") . '</td>
					<td class="text-center">ID: ' . $v['id_standar_harga'] . '<br>Update pada:<br>' . $v['update_at'] . '</td>
					<td>' . $v['kode_standar_harga'] . '</td>
					<td>' . $v['nama_standar_harga'] . '</td>
					<td class="text-center">' . $v['satuan'] . '</td>
					<td>' . $v['spek'] . '</td>
					<td class="text-center">' . $v['is_deleted'] . '</td>
					<td class="text-center">' . $v['is_locked'] . '</td>
					<td class="text-center">' . $kelompok . '</td>
					<td class="text-right">Rp ' . number_format($v['harga'], 2, ",", ".") . '</td>
					<td>' . implode('<br>', $rek) . '</td>
				</tr>
			';
			$no++;
		}
		if (empty($tbody)) {
			$tbody = '<tr><td colspan="11" class="text-center">Data Kosong!</td></tr>';
		}
		$table = '
			<style>
				.text-center {
					text-align: center;
				}
				.text-right {
					text-align: right;
				}
			</style>
			<table>
				<thead>
					<tr>
						<th class="text-center">No</th>
						<th class="text-center">ID Standar Harga</th>
						<th class="text-center">Kode</th>
						<th class="text-center" style="width: 200px;">Nama</th>
						<th class="text-center">Satuan</th>
						<th class="text-center" style="width: 200px;">Spek</th>
						<th class="text-center">Deleted</th>
						<th class="text-center">Locked</th>
						<th class="text-center">Kelompok</th>
						<th class="text-center">Harga</th>
						<th class="text-center">Rekening Belanja</th>
					</tr>
				</thead>
				<tbody>' . $tbody . '</tbody>
			</table>
		';
		echo $table;
	}

	public function singkron_user_deskel()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil export data desa/kelurahan!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == APIKEY) {
				if (!empty($_POST['data'])) {
					$data = $_POST['data'];
					$cek = $wpdb->get_var("SELECT id_lurah from data_desa_kelurahan where tahun_anggaran=".$_POST['tahun_anggaran']." AND id_lurah=" . $data['id_lurah']);
					$opsi = $data + array(
						'update_at' => current_time('mysql'),
						'tahun_anggaran' => $_POST['tahun_anggaran']
					);
					if (!empty($cek)) {
						$wpdb->update('data_desa_kelurahan', $opsi, array(
							'id_lurah' => $v['id_lurah'],
							'tahun_anggaran' => $_POST['tahun_anggaran']
						));
					} else {
						$wpdb->insert('data_desa_kelurahan', $opsi);
					}
					// print_r($ssh); die();
				} else {
					$ret['status'] = 'error';
					$ret['message'] = 'Format Data Desa/Kelurahan Salah!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	public function singkron_user_dewan()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil export data anggota dewan!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == APIKEY) {
				if (!empty($_POST['data'])) {
					$data = $_POST['data'];
					$cek = $wpdb->get_var("SELECT iduser from data_dewan where tahun_anggaran=".$_POST['tahun_anggaran']." AND iduser=" . $data['iduser']);
					$opsi = $data + array(
						'update_at' => current_time('mysql'),
						'tahun_anggaran' => $_POST['tahun_anggaran']
					);
					if (!empty($cek)) {
						$wpdb->update('data_dewan', $opsi, array(
							'iduser' => $v['iduser'],
							'tahun_anggaran' => $_POST['tahun_anggaran']
						));
					} else {
						$wpdb->insert('data_dewan', $opsi);
					}
					// print_r($ssh); die();
				} else {
					$ret['status'] = 'error';
					$ret['message'] = 'Format Data Dewan Salah!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	public function singkron_pengaturan_sipd()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil export data pengaturan SIPD!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == APIKEY) {
				if (!empty($_POST['data'])) {
					$data = $_POST['data'];
					$cek = $wpdb->get_var("SELECT kepala_daerah from data_pengaturan_sipd where tahun_anggaran=".$_POST['tahun_anggaran']." AND kepala_daerah='".$data['kepala_daerah']."'");
					$opsi = $data + array(
						'update_at' => current_time('mysql'),
						'tahun_anggaran' => $_POST['tahun_anggaran']
					);
					carbon_set_theme_option( 'crb_daerah', $data['daerah'] );
					carbon_set_theme_option( 'crb_kepala_daerah', $data['kepala_daerah'] );
					carbon_set_theme_option( 'crb_wakil_daerah', $data['wakil_kepala_daerah'] );
					if (!empty($cek)) {
						$wpdb->update('data_pengaturan_sipd', $opsi, array(
							'kepala_daerah' => $v['kepala_daerah'],
							'tahun_anggaran' => $_POST['tahun_anggaran']
						));
					} else {
						$wpdb->insert('data_pengaturan_sipd', $opsi);
					}
					// print_r($ssh); die();
				} else {
					$ret['status'] = 'error';
					$ret['message'] = 'Format Data Dewan Salah!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	public function singkron_akun_belanja()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil export Akun Rekening Belanja!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == APIKEY) {
				if (!empty($_POST['akun'])) {
					$akun = $_POST['akun'];
					foreach ($akun as $k => $v) {
						$cek = $wpdb->get_var("SELECT id_akun from data_akun where tahun_anggaran=".$_POST['tahun_anggaran']." AND id_akun=" . $v['id_akun']);
						$opsi = $v + array(
							'update_at' => current_time('mysql'),
							'tahun_anggaran' => $_POST['tahun_anggaran']
						);
						if (!empty($cek)) {
							$wpdb->update('data_akun', $opsi, array(
								'id_akun' => $v['id_akun'],
								'tahun_anggaran' => $_POST['tahun_anggaran']
							));
						} else {
							$wpdb->insert('data_akun', $opsi);
						}
					}
					// print_r($ssh); die();
				} else {
					$ret['status'] = 'error';
					$ret['message'] = 'Format Akun Belanja Salah!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	public function singkron_unit()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil export Unit!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == APIKEY) {
				if (!empty($_POST['data_unit'])) {
					$data_unit = $_POST['data_unit'];
					foreach ($data_unit as $k => $v) {
						$cek = $wpdb->get_var("SELECT id_skpd from data_unit where tahun_anggaran=".$_POST['tahun_anggaran']." AND id_skpd=" . $v['id_skpd']);
						$opsi = $v + array(
							'active' => 1,
							'update_at' => current_time('mysql'),
							'tahun_anggaran' => $_POST['tahun_anggaran']
						);

						if (!empty($cek)) {
							$wpdb->update('data_unit', $opsi, array(
								'id_skpd' => $v['id_skpd'],
								'tahun_anggaran' => $_POST['tahun_anggaran']
							));
						} else {
							$wpdb->insert('data_unit', $opsi);
						}
					}
				} else if ($ret['status'] != 'error') {
					$ret['status'] = 'error';
					$ret['message'] = 'Tidak ada data unit yang dikirim!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}
	public function singkron_data_giat()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil set program kegiatan!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == APIKEY) {
				if (!empty($_POST['subgiat'])) {
					$sub_giat = $_POST['subgiat'];
					foreach ($sub_giat as $k => $v) {
						$cek = $wpdb->get_var("SELECT id_sub_giat from data_prog_keg where tahun_anggaran=".$_POST['tahun_anggaran']." AND id_sub_giat=" . $v['id_sub_giat']);
						$opsi = $v + array(
							'update_at' => current_time('mysql'),
							'tahun_anggaran' => $_POST['tahun_anggaran']
						);

						if (!empty($cek)) {
							$wpdb->update('data_prog_keg', $opsi, array(
								'id_sub_giat' => $v['id_sub_giat'],
								'tahun_anggaran' => $_POST['tahun_anggaran']
							));
						} else {
							$wpdb->insert('data_prog_keg', $opsi);
						}
					}
				} else if ($ret['status'] != 'error') {
					$ret['status'] = 'error';
					$ret['message'] = 'Format data Salah!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	public function singkron_data_rpjmd()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil set program kegiatan!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == APIKEY) {
				if (!empty($_POST['rpjmd'])) {
					$data_rpjmd = $_POST['rpjmd'];
					foreach ($data_rpjmd as $k => $v) {
						$cek = $wpdb->get_var("SELECT id_rpjmd from data_rpjmd where tahun_anggaran=".$_POST['tahun_anggaran']." AND id_rpjmd=" . $v['id_rpjmd']);
						$opsi = $v + array(
							'update_at' => current_time('mysql'),
							'tahun_anggaran' => $_POST['tahun_anggaran']
						);

						if (!empty($cek)) {
							$wpdb->update('data_rpjmd', $opsi, array(
								'id_rpjmd' => $v['id_rpjmd'],
								'tahun_anggaran' => $_POST['tahun_anggaran']
							));
						} else {
							$wpdb->insert('data_rpjmd', $opsi);
						}
					}
				} else if ($ret['status'] != 'error') {
					$ret['status'] = 'error';
					$ret['message'] = 'Format data Salah!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	public function singkron_sumber_dana()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil set program kegiatan!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == APIKEY) {
				if (!empty($_POST['dana'])) {
					$sumber_dana = $_POST['dana'];
					foreach ($sumber_dana as $k => $v) {
						$cek = $wpdb->get_var("SELECT id_dana from data_sumber_dana where tahun_anggaran=".$_POST['tahun_anggaran']." AND id_dana=" . $v['id_dana']);
						$opsi = $v + array(
							'updated_at' => current_time('mysql'),
							'tahun_anggaran' => $_POST['tahun_anggaran']
						);

						if (!empty($cek)) {
							$wpdb->update('data_sumber_dana', $opsi, array(
								'id_dana' => $v['id_dana'],
								'tahun_anggaran' => $_POST['tahun_anggaran']
							));
						} else {
							$wpdb->insert('data_sumber_dana', $opsi);
						}
					}
				} else if ($ret['status'] != 'error') {
					$ret['status'] = 'error';
					$ret['message'] = 'Format data Salah!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	public function singkron_alamat()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil singkron alamat!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == APIKEY) {
				if (!empty($_POST['alamat'])) {
					$alamat = $_POST['alamat'];
					foreach ($alamat as $k => $v) {
						$cek = $wpdb->get_var("SELECT id from data_alamat where tahun=".$_POST['tahun_anggaran']." 
						AND id_alamat='" . $v['id_alamat']."' 
						AND is_prov='" . $v['is_prov']."' 
						AND is_kab='" . $v['is_kab']."' 
						AND is_kec='" . $v['is_kec']."' 
						AND is_kel='" . $v['is_kel'] . "'");
						$opsi = $v + array(
							'tahun' => $_POST['tahun_anggaran'],
							'updated_at' => current_time('mysql')
						);

						if (!empty($cek)) {
							$wpdb->update('data_alamat', $opsi, array(
								'tahun' => $_POST['tahun_anggaran'],
								'id' => $cek
							));
						} else {
							$wpdb->insert('data_alamat', $opsi);
						}
					}
				} else if ($ret['status'] != 'error') {
					$ret['status'] = 'error';
					$ret['message'] = 'Format data Salah!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	public function singkron_penerima_bantuan()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil set profile penerima bantuan!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == APIKEY) {
				if (!empty($_POST['profile'])) {
					$profile = $_POST['profile'];
					foreach ($profile as $k => $v) {
						$cek = $wpdb->get_var("SELECT id_profil from data_profile_penerima_bantuan where tahun=".$_POST['tahun_anggaran']." AND id_profil=" . $v['id_profil']);
						$opsi = $v + array(
							'tahun' => $_POST['tahun_anggaran'],
							'updated_at' => current_time('mysql')
						);

						if (!empty($cek)) {
							$wpdb->update('data_profile_penerima_bantuan', $opsi, array(
								'tahun' => $_POST['tahun_anggaran'],
								'id_profil' => $v['id_profil']
							));
						} else {
							$wpdb->insert('data_profile_penerima_bantuan', $opsi);
						}
					}
				} else if ($ret['status'] != 'error') {
					$ret['status'] = 'error';
					$ret['message'] = 'Format data Salah!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	public function set_unit_pagu()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil set unit pagu!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == APIKEY) {
				if (!empty($_POST['data'])) {
					$data_unit = $_POST['data'];
					$cek = $wpdb->get_var("SELECT id_skpd from data_unit_pagu where tahun_anggaran=".$_POST['tahun_anggaran']." AND id_skpd=" . $data_unit['id_skpd']);
					// id_unit di data ini adalah induk organisasi. Sedangkan pagu bukan di induk organisasi, tapi di induk rka. Data skpd yg dikirim adalah data induk rka.
					$opsi = $data_unit + array(
						'update_at' => current_time('mysql'),
						'tahun_anggaran' => $_POST['tahun_anggaran']
					);

					if (!empty($cek)) {
						$wpdb->update('data_unit_pagu', $opsi, array(
							'id_skpd' => $data_unit['id_skpd'],
							'tahun_anggaran' => $_POST['tahun_anggaran']
						));
						$ret['message'] = 'Sukses Update data_unit_pagu !';
					} else {
						$wpdb->insert('data_unit_pagu', $opsi);
						$ret['message'] = 'Sukses Insert data_unit_pagu !';
					}
				} else if ($ret['status'] != 'error') {
					$ret['status'] = 'error';
					$ret['message'] = 'Format data Salah!';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	public function singkron_rka()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil export RKA!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == APIKEY) {
				$parent_cat_name = 'Semua Perangkat Daerah Tahun Anggaran ' . $_POST['tahun_anggaran'];
				$taxonomy = 'category';
				$parent_cat  = get_term_by('name', $parent_cat_name, $taxonomy);
				if ($parent_cat == false) {
					$parent_cat = wp_insert_term($parent_cat_name, $taxonomy);
					$parent_cat_id = $parent_cat['term_id'];
				} else {
					$parent_cat_id = $parent_cat->term_id;
				}

				if (!empty($_POST['data_unit'])) {
					$data_unit = $_POST['data_unit'];
					$cek = $wpdb->get_var("SELECT id_skpd from data_unit where tahun_anggaran=".$_POST['tahun_anggaran']." AND id_skpd=" . $data_unit['id_skpd']);
					$opsi = $data_unit + array(
						'active' => 1,
						'update_at' => current_time('mysql'),
						'tahun_anggaran' => $_POST['tahun_anggaran']
					);

					if (!empty($cek)) {
						$wpdb->update('data_unit', $opsi, array(
							'id_skpd' => $data_unit['id_skpd'],
							'tahun_anggaran' => $_POST['tahun_anggaran']
						));
					} else {
						$wpdb->insert('data_unit', $opsi);
					}
				} else if ($ret['status'] != 'error') {
					$ret['status'] = 'error';
					$ret['message'] = 'Data singkron_rka yg dikirim ke wp-sipd tidak disertai data Unit!';
				}
				if (!empty($_POST['dataBl']) && $ret['status'] != 'error') {
					$dataBl = $_POST['dataBl'];
					foreach ($dataBl as $k => $v) {
						$cek = $wpdb->get_var("SELECT kode_sbl from data_sub_keg_bl where tahun_anggaran=".$_POST['tahun_anggaran']." AND kode_sbl='" . $_POST['kode_sbl'] . "'");
						$opsi = $v + array(
							'kode_skpd' => $_POST['kode_skpd'],
							'nama_skpd' => $_POST['nama_skpd'],
							'kode_sub_skpd' => $_POST['kode_sub_skpd'],
							'pagu_keg' => $_POST['pagu'],
							'kode_bl' => $_POST['kode_bl'],
							'kode_sbl' => $_POST['kode_sbl'],
							'active' => 1,
							'update_at' => current_time('mysql'),
							'tahun_anggaran' => $_POST['tahun_anggaran']
						);
						if (!empty($cek)) {
							$wpdb->update('data_sub_keg_bl', $opsi, array(
								'kode_sbl' => $v['kode_sbl'],
								'tahun_anggaran' => $_POST['tahun_anggaran']
							));
						} else {
							$wpdb->insert('data_sub_keg_bl', $opsi);
						}

						$nama_page = $_POST['tahun_anggaran'] . ' ' . $v['nama_sub_skpd'] . ' ' . $v['kode_giat'] . ' ' . $v['nama_giat'];
						$custom_post = get_page_by_title($nama_page, OBJECT, 'post');
						// print_r($custom_post); die();

						$nama_page_1 = $_POST['tahun_anggaran'] . ' ' . $v['nama_sub_skpd'] . ' ' . $v['kode_giat'] . ' ' . $v['nama_giat'] . ' v1';
						$custom_post_1 = get_page_by_title($nama_page_1, OBJECT, 'post');
						// print_r($custom_post); die();

						$cat_name = $v['nama_sub_skpd'];
						$taxonomy = 'category';
						$cat  = get_term_by('name', $cat_name, $taxonomy);
						// print_r($cat); die($cat_name);
						if ($cat == false) {
							$cat = wp_insert_term($cat_name, $taxonomy);
							$cat_id = $cat['term_id'];
						} else {
							$cat_id = $cat->term_id;
						}
						wp_update_term($cat_id, $taxonomy, array(
							'parent' => $parent_cat_id
						));

						if (empty($custom_post) || empty($custom_post->ID)) {
							$id = wp_insert_post(array(
								'post_title'	=> $nama_page,
								'post_content'	=> '[tampilrka kode_bl=' . $_POST['kode_bl'] . ']',
								'post_type'		=> 'post',
								'post_status'	=> 'publish'
							));
							$custom_post = get_page_by_title($nama_page, OBJECT, 'post');
							update_post_meta($custom_post->ID, 'ast-breadcrumbs-content', 'disabled');
							update_post_meta($custom_post->ID, 'ast-featured-img', 'disabled');
							update_post_meta($custom_post->ID, 'ast-main-header-display', 'disabled');
							update_post_meta($custom_post->ID, 'footer-sml-layout', 'disabled');
							update_post_meta($custom_post->ID, 'site-content-layout', 'page-builder');
							update_post_meta($custom_post->ID, 'site-post-title', 'disabled');
							update_post_meta($custom_post->ID, 'site-sidebar-layout', 'no-sidebar');
							update_post_meta($custom_post->ID, 'theme-transparent-header-meta', 'disabled');
						}

						if (empty($custom_post_1) || empty($custom_post_1->ID)) {
							$id = wp_insert_post(array(
								'post_title'	=> $nama_page_1,
								'post_content'	=> '[tampilrka_v1 kode_bl=' . $_POST['kode_bl'] . ']',
								'post_type'		=> 'post',
								'post_status'	=> 'publish'
							));
							$custom_post_1 = get_page_by_title($nama_page_1, OBJECT, 'post');
							update_post_meta($custom_post_1->ID, 'ast-breadcrumbs-content', 'disabled');
							update_post_meta($custom_post_1->ID, 'ast-featured-img', 'disabled');
							update_post_meta($custom_post_1->ID, 'ast-main-header-display', 'disabled');
							update_post_meta($custom_post_1->ID, 'footer-sml-layout', 'disabled');
							update_post_meta($custom_post_1->ID, 'site-content-layout', 'page-builder');
							update_post_meta($custom_post_1->ID, 'site-post-title', 'disabled');
							update_post_meta($custom_post_1->ID, 'site-sidebar-layout', 'no-sidebar');
							update_post_meta($custom_post_1->ID, 'theme-transparent-header-meta', 'disabled');
						}

						// https://stackoverflow.com/questions/3010124/wordpress-insert-category-tags-automatically-if-they-dont-exist
						$append = true;
						wp_set_post_terms($custom_post->ID, array($cat_id), $taxonomy, $append);
						$category_link = get_category_link($cat_id);

						$ret['message'] .= ' URL ' . $custom_post->guid;
						$ret['category'] = $category_link;

						wp_set_post_terms($custom_post_1->ID, array($cat_id), $taxonomy, $append);
						$category_link = get_category_link($cat_id);

						$ret['message'] .= ' URL ' . $custom_post_1->guid;
						$ret['category'] = $category_link;
					}
				} else if ($ret['status'] != 'error') {
					$ret['status'] = 'error';
					$ret['message'] = 'Data singkron_rka yang dikirim ke wp-sipd tidak disertai data BL!';
				}

				if (!empty($_POST['dataOutput']) && $ret['status'] != 'error') {
					$dataOutput = $_POST['dataOutput'];
					$wpdb->update('data_sub_keg_indikator', array( 'active' => 0 ), array(
						'tahun_anggaran' => $_POST['tahun_anggaran'],
						'kode_sbl' => $_POST['kode_sbl']
					));
					foreach ($dataOutput as $k => $v) {
						$cek = $wpdb->get_var("SELECT kode_sbl from data_sub_keg_indikator where tahun_anggaran=".$_POST['tahun_anggaran']." AND kode_sbl='" . $_POST['kode_sbl'] . "' AND idoutputbl='" . $v['idoutputbl'] . "'");
						$opsi = $v + array(
							'kode_sbl' => $_POST['kode_sbl'],
							'idsubbl' => $_POST['idsubbl'],
							'active' => 1,
							'update_at' => current_time('mysql'),
							'tahun_anggaran' => $_POST['tahun_anggaran']
						);
						if (!empty($cek)) {
							$wpdb->update('data_sub_keg_indikator', $opsi, array(
								'kode_sbl' => $_POST['kode_sbl'],
								'idoutputbl' => $_POST['idoutputbl'],
								'tahun_anggaran' => $_POST['tahun_anggaran']
							));
						} else {
							$wpdb->insert('data_sub_keg_indikator', $opsi);
						}
					}
				}

				if (!empty($_POST['dataTag']) && $ret['status'] != 'error') {
					$dataTag = $_POST['dataTag'];
					$wpdb->update('data_tag_sub_keg', array( 'active' => 0 ), array(
						'tahun_anggaran' => $_POST['tahun_anggaran'],
						'kode_sbl' => $_POST['kode_sbl']
					));
					foreach ($dataTag as $k => $v) {
						$cek = $wpdb->get_var("SELECT kode_sbl from data_tag_sub_keg where tahun_anggaran=".$_POST['tahun_anggaran']." AND kode_sbl='" . $_POST['kode_sbl'] . "' AND idtagbl='" . $v['idtagbl'] . "'");
						$opsi = $v + array(
							'kode_sbl' => $_POST['kode_sbl'],
							'idsubbl' => $_POST['idsubbl'],
							'active' => 1,
							'update_at' => current_time('mysql'),
							'tahun_anggaran' => $_POST['tahun_anggaran']
						);
						if (!empty($cek)) {
							$wpdb->update('data_tag_sub_keg', $opsi, array(
								'kode_sbl' => $_POST['kode_sbl'],
								'idtagbl' => $v['idtagbl'],
								'tahun_anggaran' => $_POST['tahun_anggaran']
							));
						} else {
							$wpdb->insert('data_tag_sub_keg', $opsi);
						}
					}
				}

				if (!empty($_POST['dataCapaian']) && $ret['status'] != 'error') {
					$dataCapaian = $_POST['dataCapaian'];
					$wpdb->update('data_capaian_prog_sub_keg', array( 'active' => 0 ), array(
						'tahun_anggaran' => $_POST['tahun_anggaran'],
						'kode_sbl' => $_POST['kode_sbl']
					));
					foreach ($dataCapaian as $k => $v) {
						$cek = $wpdb->get_var("SELECT kode_sbl from data_capaian_prog_sub_keg where tahun_anggaran=".$_POST['tahun_anggaran']." AND kode_sbl='" . $_POST['kode_sbl'] . "' AND capaianteks='" . $v['capaianteks'] . "'");
						$opsi = $v + array(
							'kode_sbl' => $_POST['kode_sbl'],
							'idsubbl' => $_POST['idsubbl'],
							'active' => 1,
							'update_at' => current_time('mysql'),
							'tahun_anggaran' => $_POST['tahun_anggaran']
						);
						if (!empty($cek)) {
							$wpdb->update('data_capaian_prog_sub_keg', $opsi, array(
								'kode_sbl' => $_POST['kode_sbl'],
								'capaianteks' => $v['capaianteks'],
								'tahun_anggaran' => $_POST['tahun_anggaran']
							));
						} else {
							$wpdb->insert('data_capaian_prog_sub_keg', $opsi);
						}
					}
				}

				if (!empty($_POST['dataOutputGiat']) && $ret['status'] != 'error') {
					$dataOutputGiat = $_POST['dataOutputGiat'];
					$wpdb->update('data_output_giat_sub_keg', array( 'active' => 0 ), array(
						'tahun_anggaran' => $_POST['tahun_anggaran'],
						'kode_sbl' => $_POST['kode_sbl']
					));
					foreach ($dataOutputGiat as $k => $v) {
						$cek = $wpdb->get_var("SELECT kode_sbl from data_output_giat_sub_keg where tahun_anggaran=".$_POST['tahun_anggaran']." AND kode_sbl='" . $_POST['kode_sbl'] . "' AND outputteks='" . $v['outputteks'] . "'");
						$opsi = $v + array(
							'kode_sbl' => $_POST['kode_sbl'],
							'idsubbl' => $_POST['idsubbl'],
							'active' => 1,
							'update_at' => current_time('mysql'),
							'tahun_anggaran' => $_POST['tahun_anggaran']
						);
						if (!empty($cek)) {
							$wpdb->update('data_output_giat_sub_keg', $opsi, array(
								'kode_sbl' => $_POST['kode_sbl'],
								'outputteks' => $v['outputteks'],
								'tahun_anggaran' => $_POST['tahun_anggaran']
							));
						} else {
							$wpdb->insert('data_output_giat_sub_keg', $opsi);
						}
					}
				}

				if (!empty($_POST['dataDana']) && $ret['status'] != 'error') {
					$dataDana = $_POST['dataDana'];
					$wpdb->update('data_dana_sub_keg', array( 'active' => 0 ), array(
						'tahun_anggaran' => $_POST['tahun_anggaran'],
						'kode_sbl' => $_POST['kode_sbl']
					));
					foreach ($dataDana as $k => $v) {
						$cek = $wpdb->get_var("SELECT kode_sbl from data_dana_sub_keg where tahun_anggaran=".$_POST['tahun_anggaran']." AND kode_sbl='" . $_POST['kode_sbl'] . "' AND iddanasubbl='" . $v['iddanasubbl'] . "'");
						$opsi = $v + array(
							'kode_sbl' => $_POST['kode_sbl'],
							'idsubbl' => $_POST['idsubbl'],
							'active' => 1,
							'update_at' => current_time('mysql'),
							'tahun_anggaran' => $_POST['tahun_anggaran']
						);
						if (!empty($cek)) {
							$wpdb->update('data_dana_sub_keg', $opsi, array(
								'kode_sbl' => $_POST['kode_sbl'],
								'iddanasubbl' => $v['iddanasubbl'],
								'tahun_anggaran' => $_POST['tahun_anggaran']
							));
						} else {
							$wpdb->insert('data_dana_sub_keg', $opsi);
						}
					}
				}

				if (!empty($_POST['rka']) && $ret['status'] != 'error') {
					$rka = $_POST['rka'];
					$wpdb->update('data_rka', array( 'active' => 0 ), array(
						'tahun_anggaran' => $_POST['tahun_anggaran'],
						'kode_sbl' => $_POST['kode_sbl']
					));
					foreach ($rka as $k => $v) {
						$cek = $wpdb->get_var("SELECT id_rinci_sub_bl from data_rka where tahun_anggaran=".$_POST['tahun_anggaran']." AND id_rinci_sub_bl='" . $v['id_rinci_sub_bl'] . "'");
						$opsi = $v + array(
							'idbl' => $_POST['idbl'],
							'idsubbl' => $_POST['idsubbl'],
							'kode_bl' => $_POST['kode_bl'],
							'kode_sbl' => $_POST['kode_sbl'],
							'active' => 1,
							'update_at' => current_time('mysql'),
							'tahun_anggaran' => $_POST['tahun_anggaran']
						);
						if (!empty($cek)) {
							$wpdb->update('data_rka', $opsi, array(
								'tahun_anggaran' => $_POST['tahun_anggaran'],
								'id_rinci_sub_bl' => $v['id_rinci_sub_bl']
							));
						} else {
							$wpdb->insert('data_rka', $opsi);
						}
					}
					// print_r($ssh); die();
				} else if ($ret['status'] != 'error') {
					$wpdb->update('data_rka', array( 'active' => 0 ), array(
						'tahun_anggaran' => $_POST['tahun_anggaran'],
						'kode_sbl' => $_POST['kode_sbl']
					));
					$ret['status'] = 'error';
					$ret['message'] = 'Data singkron_rka yg dikirim ke wp-sipd tidak disertai rincian belanja! ';
					$ret['message'] .= 'Hanya menyimpan sampai dengan data sub kegiatan.';
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Tidak ada data yang dikirim!';
		}
		die(json_encode($ret));
	}

	public function getSSH()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil export Akun Rekening Belanja!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['id_akun'])) {
				$data_ssh = $wpdb->get_results(
					$wpdb->prepare("
					SELECT 
						s.id_standar_harga, 
						s.nama_standar_harga, 
						s.kode_standar_harga 
					from data_ssh_rek_belanja r
						join data_ssh s ON r.id_standar_harga=s.id_standar_harga
					where r.id_akun=%d", $_POST['id_akun']),
					ARRAY_A
				);
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'Format ID Salah!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	public function rekbelanja($atts)
	{
		$a = shortcode_atts(array(
			'filter' => '',
		), $atts);
		global $wpdb;

		$data_akun = $wpdb->get_results(
			"
			SELECT 
				* 
			from data_akun 
			where belanja='Ya'
				AND is_barjas=1
				AND set_input=1",
			ARRAY_A
		);
		$tbody = '';
		$no = 1;
		foreach ($data_akun as $k => $v) {
			// if($k >= 100){ continue; }
			$data_ssh = $wpdb->get_results(
				"
				SELECT 
					s.id_standar_harga, 
					s.nama_standar_harga, 
					s.kode_standar_harga 
				from data_ssh_rek_belanja r
					join data_ssh s ON r.id_standar_harga=s.id_standar_harga
				where r.id_akun=" . $v['id_akun'],
				ARRAY_A
			);

			$ssh = array();
			foreach ($data_ssh as $key => $value) {
				$ssh[] = '(' . $value['id_standar_harga'] . ') ' . $value['kode_standar_harga'] . ' ' . $value['nama_standar_harga'];
			}
			if (!empty($a['filter'])) {
				if ($a['filter'] == 'ssh_kosong' && !empty($ssh)) {
					continue;
				}
			}

			$html_ssh = '';
			if (!empty($ssh)) {
				$html_ssh = '
					<a class="btn btn-primary" data-toggle="collapse" href="#collapseSSH' . $k . '" role="button" aria-expanded="false" aria-controls="collapseSSH' . $k . '">
				    	Lihat Item SSH Total (' . count($ssh) . ')
				  	</a>
				  	<div class="collapse" id="collapseSSH' . $k . '">
					  	<div class="card card-body">
				  			' . implode('<br>', $ssh) . '
					  	</div>
					</div>
				';
			}
			$tbody .= '
				<tr>
					<td class="text-center">' . number_format($no, 0, ",", ".") . '</td>
					<td class="text-center">ID: ' . $v['id_akun'] . '<br>Update pada:<br>' . $v['update_at'] . '</td>
					<td>' . $v['kode_akun'] . '</td>
					<td>' . $v['nama_akun'] . '</td>
					<td>' . $html_ssh . '</td>
				</tr>
			';
			$no++;
		}
		if (empty($tbody)) {
			$tbody = '<tr><td colspan="5" class="text-center">Data Kosong!</td></tr>';
		}
		$table = '
			<style>
				.text-center {
					text-align: center;
				}
				.text-right {
					text-align: right;
				}
			</style>
			<table>
				<thead>
					<tr>
						<th class="text-center" style="width: 30px;">No</th>
						<th class="text-center" style="width: 200px;">ID Akun</th>
						<th class="text-center" style="width: 100px;">Kode</th>
						<th class="text-center" style="width: 400px;">Nama</th>
						<th class="text-center">Item SSH</th>
					</tr>
				</thead>
				<tbody>' . $tbody . '</tbody>
			</table>
		';
		echo $table;
	}

	public function tampilrka($atts)
	{
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wpsipd-public-rka.php';
	}

	public function tampilrka_v1($atts)
	{
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wpsipd-public-rka-v1.php';
	}

	public function tampilrekap()
	{
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wpsipd-public-rekap-rincian-unit.php';
	}

	public function get_cat_url()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'URL ...'
		);
		if (!empty($_POST)) {
			$cat_name = $_POST['category'];
			$taxonomy = 'category';
			$cat  = get_term_by('name', $cat_name, $taxonomy);
			if (!empty($cat)) {
				$category_link = get_category_link($cat->term_id);
				$ret['message'] = 'URL Category ' . $category_link;
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'Category tidak ditemukan!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Tidak ada data yang dikirim!';
		}
		die(json_encode($ret));
	}
}
