import pandas as pd
from sklearn.cluster import KMeans
import sys

# Baca file input dari Laravel
df = pd.read_csv(r"C:\laragon\www\dinassosial\storage\app\clustering\dtks_input.csv")

# Debugging: Tampilkan jumlah data yang dibaca
print(f"Jumlah data yang dibaca: {len(df)}")

# Pilih fitur numerik untuk klasterisasi, Hapus 'cluster_id' karena itu adalah target yang akan dihasilkan
features = df[['pekerjaan',
               'kepemilikan_rumah',
               'jenis_atap',
               'jenis_dinding',
               'jenis_lantai',
               'sumber_penerangan',
               'daya_listrik',
               'bahan_bakar',
               'sumber_air',
               'fasilitas_bab']]

# Ambil jumlah kluster dari argumen
k = int(sys.argv[1]) if len(sys.argv) > 1 else 3

# Jalankan KMeans dengan 10 iterasi
kmeans = KMeans(n_clusters=k, max_iter=10, random_state=42)
df['cluster_id'] = kmeans.fit_predict(features)

# Debugging: Tampilkan beberapa hasil klasterisasi
print(f"Data klasterisasi:\n{df[['id', 'cluster_id']].head()}")

# Simpan hasil (id + cluster_id)
df[['id', 'cluster_id']].to_csv(r"C:\laragon\www\dinassosial\storage\app\clustering\dtks_output.csv", index=False)

print(f'Klasterisasi selesai. Hasil disimpan di storage/app/clustering/dtks_output.csv')
