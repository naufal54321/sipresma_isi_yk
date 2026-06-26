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
 * @property int|null $master_kegiatan_id
 * @property string $kegiatan
 * @property string $jenis
 * @property string|null $judul_kegiatan
 * @property string|null $tanggal
 * @property string|null $kategori
 * @property string|null $peran
 * @property int|null $jumlah_anggota
 * @property string|null $catatan_dosen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $anggota
 * @property-read int|null $anggota_count
 * @property-read \App\Models\MasterKegiatan|null $masterKegiatan
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereJenis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereJudulKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereJumlahAnggota($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereMasterKegiatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan wherePeran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereRpkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kegiatan whereUserId($value)
 */
	class Kegiatan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_kegiatan
 * @property string $jenis
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Kegiatan> $kegiatans
 * @property-read int|null $kegiatans_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rpk> $rpks
 * @property-read int|null $rpks_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKegiatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKegiatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKegiatan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKegiatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKegiatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKegiatan whereJenis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKegiatan whereNamaKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKegiatan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKegiatan whereUpdatedAt($value)
 */
	class MasterKegiatan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $juara
 * @property int $poin
 * @property string|null $tingkat
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPrestasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPrestasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPrestasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPrestasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPrestasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPrestasi whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPrestasi whereJuara($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPrestasi wherePoin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPrestasi whereTingkat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPrestasi whereUpdatedAt($value)
 */
	class MasterPrestasi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_prodi
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramStudi whereCreatedAt($value)
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
 * @property int|null $master_kegiatan_id
 * @property string $tahun
 * @property string $semester
 * @property string $kategori
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $status
 * @property string|null $catatan_dosen
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Kegiatan> $kegiatans
 * @property-read int|null $kegiatans_count
 * @property-read \App\Models\MasterKegiatan|null $masterKegiatan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Spk> $spks
 * @property-read int|null $spks_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereCatatanDosen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereMasterKegiatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rpk whereUserId($value)
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
 * @property string $tanggal_kegiatan
 * @property string $penyelenggara
 * @property string $kategori
 * @property int|null $prestasi_id
 * @property string|null $hasil
 * @property string|null $judul_kegiatan
 * @property int $poin
 * @property string|null $tingkat
 * @property string|null $url_kegiatan
 * @property string $bukti
 * @property string $keterangan
 * @property string $status
 * @property string|null $catatan_dosen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kegiatan $kegiatan
 * @property-read \App\Models\Rpk $rpk
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereBukti($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereCatatanDosen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereHasil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereJudulKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereKegiatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk wherePenyelenggara($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk wherePoin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk wherePrestasiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereRpkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereTanggalKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereTingkat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereUrlKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Spk whereUserId($value)
 */
	class Spk extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $nim
 * @property string|null $prodi
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $dosen_pembimbing_id
 * @property string $status
 * @property bool $is_approved
 * @property-read User|null $dosenPembimbing
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Kegiatan> $kegiatanAnggota
 * @property-read int|null $kegiatan_anggota_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $mahasiswaBimbingan
 * @property-read int|null $mahasiswa_bimbingan_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rpk> $rpks
 * @property-read int|null $rpks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Spk> $spks
 * @property-read int|null $spks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $teams
 * @property-read int|null $teams_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User mahasiswaBimbingan($dosenId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User team($teams, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDosenPembimbingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNim($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProdi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTeam($teams)
 */
	class User extends \Eloquent {}
}

