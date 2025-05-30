import { useState } from 'react';
import axios from '../axios/link';

const useDelete = () => {
  const [pesan, setPesan] = useState('');

  const hapus = async (url, id, setData) => {
    if (window.confirm('Apakah Anda yakin ingin menghapus data ini?')) {
      try {
        console.log('Menghapus data dengan ID:', id);
        const response = await axios.delete(`${url}/${id}`);
        console.log('Response dari server:', response.data);
        setPesan(response.data.pesan);
        
        const newData = await axios.get(url);
        setData(newData.data);
      } catch (error) {
        console.error(`Error deleting data:`, error);
      }
    }
  };

  return { pesan, hapus };
};

export default useDelete;