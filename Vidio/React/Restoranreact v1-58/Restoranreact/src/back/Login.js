import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from '../axios/link';

const Login = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [pesan, setPesan] = useState('');
  const navigate = useNavigate();

  // Handle submit login
  const handleSubmit = async (e) => {
    e.preventDefault();
    // Debug log
    console.log('Login Dengan : ', { email, password });

    try {
      const response = await axios.post('/login', { email, password });
      const token = response.data.token;
      const level = response.data.data?.level;
      const userEmail = response.data.data?.email;

      if (token && level) {
        // Simpan token dan info user ke localStorage
        localStorage.setItem('token', token);
        localStorage.setItem('level', level);
        localStorage.setItem('email', userEmail);
        navigate('/admin');
      } else {
        setPesan('Email atau password salah');
      }

      setEmail('');
      setPassword('');
    } catch (error) {
      console.error('Login gagal:', error);
      setPesan('Email atau password salah');
    }
  };

  return (
    <div className="container min-vh-100 d-flex align-items-center justify-content-center bg-light">
      <div className="row w-100 justify-content-center">
        <div className="col-md-6 col-lg-5">
          {/* Card Bootstrap untuk form login */}
          <div className="card shadow-lg border-0">
            <div className="card-header bg-primary text-white text-center">
              <h2 className="mb-0">Login</h2>
            </div>
            <div className="card-body p-4">
              {/* Pesan error jika login gagal */}
              {pesan && (
                <div className="alert alert-danger alert-dismissible fade show" role="alert">
                  {pesan}
                  <button type="button" className="btn-close" data-bs-dismiss="alert" aria-label="Close"
                    onClick={() => setPesan("")}></button>
                </div>
              )}

              {/* Form login */}
              <form onSubmit={handleSubmit}>
                <div className="mb-3">
                  <label htmlFor="email" className="form-label">Email</label>
                  <input
                    type="email"
                    className="form-control"
                    id="email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                    placeholder="Masukkan email anda"
                  />
                </div>

                <div className="mb-4">
                  <label htmlFor="password" className="form-label">Password</label>
                  <input
                    type="password"
                    className="form-control"
                    id="password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                    placeholder="Masukkan password"
                  />
                </div>

                <button type="submit" className="btn btn-primary w-100 fw-bold">
                  Login
                </button>
              </form>
            </div>
            <div className="card-footer text-center text-muted small">
              &copy; {new Date().getFullYear()} Alam's Resto
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Login;