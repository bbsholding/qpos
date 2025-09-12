import React, { useState } from "react";
import axios from "axios";
import toast from "react-hot-toast";

export default function CashRegisterModal({ isOpen, onClose, type = "open", onSuccess }) {
    const [amount, setAmount] = useState("");
    const [loading, setLoading] = useState(false);

    if (!isOpen) return null;

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            const url = type === "open" ? "/admin/cash-register/open" : "/admin/cash-register/close";
            const field = type === "open" ? "opening_amount" : "closing_amount";
            const res = await axios.post(url, { [field]: amount });
            toast.success(res.data.message);
            onSuccess && onSuccess(res.data.cash_register);
            onClose();
        } catch (err) {
            toast.error(err.response?.data?.message || "Erreur lors de l'opération");
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="modal show" style={{ display: "block", background: "rgba(0,0,0,0.5)" }}>
            <div className="modal-dialog">
                <div className="modal-content">
                    <div className="modal-header">
                        <h5 className="modal-title">
                            {type === "open" ? "Ouvrir la caisse" : "Fermer la caisse"}
                        </h5>
                        <button type="button" className="close" onClick={onClose}>&times;</button>
                    </div>
                    <form onSubmit={handleSubmit}>
                        <div className="modal-body">
                            <label>
                                {type === "open" ? "Montant d'ouverture" : "Montant de fermeture"}
                            </label>
                            <input
                                type="number"
                                className="form-control"
                                value={amount}
                                min={0}
                                required
                                onChange={e => setAmount(e.target.value)}
                                disabled={loading}
                            />
                        </div>
                        <div className="modal-footer">
                            <button type="button" className="btn btn-secondary" onClick={onClose} disabled={loading}>
                                Annuler
                            </button>
                            <button type="submit" className="btn btn-primary" disabled={loading}>
                                {loading ? "En cours..." : (type === "open" ? "Ouvrir" : "Fermer")}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}
