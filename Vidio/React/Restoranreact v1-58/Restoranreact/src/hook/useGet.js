import { useState, useEffect } from "react";
import axios from "../axios/link";

const useGet = (endpoint) => {
  const [isi, setIsi] = useState([]);

  useEffect(() => {
    let isMounted = true; // untuk cek apakah komponen masih aktif

    const fetchData = async () => {
      try {
        const response = await axios.get(endpoint);
        if (isMounted) {
          console.log('Data dari server:', response.data);
          setIsi(response.data);
        }
      } catch (error) {
        if (isMounted) {
          console.error(`Gagal fetch data dari ${endpoint}:`, error);
        }
      }
    };

    fetchData();

    // cleanup function
    return () => {
      isMounted = false;
    };
  }, [endpoint]);

  return { isi, setIsi };
};

export default useGet;
