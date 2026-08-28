<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $rpk_id
 * @property int|null $kkm_rule_id
 * @property int|null $poin_kkm
 * @property string $kegiatan
 * @property string|null $judul_kegiatan
 * @property \Illuminate\Support\Carbon|null $tanggal_mulai
 * @property \Illuminate\Support\Carbon|null $tanggal_selesai
 * @property string|null $kategori
 * @property string|null $peran
 * @property int|null $jumlah_anggota
 * @property string|null $catatan_dosen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $anggota
 * @property-read int|null $anggota_count
 * @property-read int|null $durasi_hari
 * @property-read string $tanggal_range
 * @property-read \App\Models\KkmRule|null $kkmRule
 * @property-read \App\Models\Rpk $rpk
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Spk> $spks
 * @property-read int|null $spks_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereCatatanDosen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereJudulKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereJumlahAnggota($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereKkmRuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan wherePeran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan wherePoinKkm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereRpkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereUserId($value)
 */
	class Kegiatan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $bidang
 * @property string $jenis_kegiatan
 * @property string|null $ruang_lingkup
 * @property string $peran
 * @property string|null $hasil
 * @property int $poin
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Kegiatan> $kegiatans
 * @property-read int|null $kegiatans_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KkmRule active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KkmRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KkmRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KkmRule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KkmRule whereBidang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KkmRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KkmRule whereHasil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KkmRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KkmRule whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KkmRule whereJenisKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KkmRule wherePeran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KkmRule wherePoin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KkmRule whereRuangLingkup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KkmRule whereUpdatedAt($value)
 */
	class KkmRule extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_prodi
 * @property string|null $fakultas
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read bool $is_active
 * @property-read string $status_badge
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi filterByStatus($status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi inactive()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi whereFakultas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi whereNamaProdi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi whereUpdatedAt($value)
 */
	class ProgramStudi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int|null $dosen_pembimbing_id
 * @property string $tahun
 * @property string $semester
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $status
 * @property string|null $catatan_dosen
 * @property int|null $verified_by
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property-read \App\Models\User|null $dosenPembimbing
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Kegiatan> $kegiatans
 * @property-read int|null $kegiatans_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Spk> $spks
 * @property-read int|null $spks_count
 * @property-read \App\Models\User $user
 * @property-read \App\Models\User|null $verifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereCatatanDosen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereDosenPembimbingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereVerifiedBy($value)
 */
	class Rpk extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $rpk_id
 * @property int $kegiatan_id
 * @property string $tahun
 * @property string|null $tanggal_kegiatan
 * @property string $penyelenggara
 * @property string $kategori
 * @property string|null $peran_sifat
 * @property string|null $judul_kegiatan
 * @property int $poin
 * @property \Illuminate\Support\Carbon|null $poin_added_at
 * @property int|null $poin_added_by
 * @property string|null $url_kegiatan
 * @property string|null $link_drive
 * @property string|null $surat_tugas
 * @property string|null $sertifikat
 * @property string|null $foto_penyerahan
 * @property string|null $laporan
 * @property string|null $judul_karya
 * @property string|null $biografi
 * @property string|null $rincian
 * @property string|null $kebaruan
 * @property string $status
 * @property string|null $catatan_dosen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $verified_by
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property-read \App\Models\Kegiatan $kegiatan
 * @property-read \App\Models\User|null $poinAddedBy
 * @property-read \App\Models\Rpk $rpk
 * @property-read \App\Models\User $user
 * @property-read \App\Models\User|null $verifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk denganPoin()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk disetujui()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk tanpaPoin()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereBiografi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereCatatanDosen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereFotoPenyerahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereJudulKarya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereJudulKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereKebaruan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereKegiatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereLaporan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereLinkDrive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk wherePenyelenggara($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk wherePeranSifat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk wherePoin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk wherePoinAddedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk wherePoinAddedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereRincian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereRpkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereSertifikat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereSuratTugas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereTanggalKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereUrlKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereVerifiedBy($value)
 */
	class Spk extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $nim
 * @property string|null $prodi
 * @property string|null $angkatan
 * @property string|null $semester
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $status
 * @property bool $is_approved
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Kegiatan> $kegiatanAnggota
 * @property-read int|null $kegiatan_anggota_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\ProgramStudi|null $programStudi
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rpk> $rpks
 * @property-read int|null $rpks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rpk> $rpksBimbingan
 * @property-read int|null $rpks_bimbingan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Spk> $spks
 * @property-read int|null $spks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $teams
 * @property-read int|null $teams_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User angkatan($angkatan)
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User mahasiswa()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User semester($semester)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User team($teams, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAngkatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNim($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProdi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTeam($teams)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

