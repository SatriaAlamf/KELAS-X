import React from 'react';
import { useParams } from 'react-router-dom';
import Kategori from './Kategori'; // Import component Kategori

const ISI = {
    KATEGORI: () => {
        return (
            <div className="card shadow-sm mb-4">
                <div className="card-header bg-primary text-white">
                    <h5 className="mb-0">Data Kategori</h5>
                </div>
                <div className="card-body">
                    <Kategori />
                </div>
            </div>
        );
    },
    
    MENU: () => {
        const { idmenu } = useParams();
        return (
            <div className="alert alert-info">
                <h2 className="h5 mb-0">Menu <span className="badge bg-secondary">{idmenu}</span></h2>
            </div>
        );
    },
    
    PELANGGAN: () => {
        const { idpelanggan } = useParams();
        return (
            <div className="alert alert-success">
                <h2 className="h5 mb-0">Pelanggan <span className="badge bg-secondary">{idpelanggan}</span></h2>
            </div>
        );
    },
    
    ORDER: () => {
        const { idorder } = useParams();
        return (
            <div className="alert alert-warning">
                <h2 className="h5 mb-0">Order <span className="badge bg-secondary">{idorder}</span></h2>
            </div>
        );
    },
    
    ORDER_DETAIL: () => {
        const { idorderdetail } = useParams();
        return (
            <div className="alert alert-secondary">
                <h2 className="h5 mb-0">Order Detail <span className="badge bg-secondary">{idorderdetail}</span></h2>
            </div>
        );
    },
    
    ADMIN: () => {
        const { idadmin } = useParams();
        return (
            <div className="alert alert-dark">
                <h2 className="h5 mb-0">Admin <span className="badge bg-secondary">{idadmin}</span></h2>
            </div>
        );
    }
};

export default ISI;