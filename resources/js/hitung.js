let nilai = 0

let terbilang = [
    'nol',
    'Satu',
    'Dua',
    'Tiga',
    'Empat',
    'Lima',
    'Enam',
    'Tujuh',
    'Delapan',
    'Sembilan',
    'Sepuluh',
    'Sebelas',
]

let bagi = 0

let teks = ''

if (nilai < 12) {
    teks = ` ${terbilang[nilai]}`
} else if (nilai < 20) {
    teks = `${terbilang[nilai -  10]} Belas`
} else if (nilai < 100) {
    bagi = Math.floor(nilai / 10)
    teks = `${terbilang[bagi]} Puluh ${terbilang[nilai % 10]}`
} else {
    teks = 'Seratus'
}

if (nilai != null) {
    console.log(teks)
}