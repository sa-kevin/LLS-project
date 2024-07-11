import { useEffect, useState } from 'react';
import BookCard from './BookCard';
import { router, usePage } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { format } from 'date-fns';

export default function BookItem({ book }) {
  const [isModalOpen, setIsModalOpen] = useState(false);
  const { flash } = usePage().props;
  const [showFlash, setShowFlash] = useState(false);

  useEffect(() => {
    if (flash && flash.book_id === book.id) {
      setShowFlash(true);
      const timer = setTimeout(() => {
        setShowFlash(false);
      }, 2000);
      return () => clearTimeout(timer);
    }
  }, [flash, book.id]);

  const handleLoans = (dueDate) => {
    const formattedDate = format(dueDate, 'yyyy-MM-dd');
    console.log('Frontend formattedDate due date:', formattedDate);
    router.post(
      route('loans.store'),
      { book_id: book.id, due_date: formattedDate },
      { preserveState: true, preserveScroll: true }
    );
    console.log('Rent:', book.title, 'due date:', formattedDate);
    setIsModalOpen(false);
  };

  const handleWaitList = () => {
    router.post(
      route('waitinglists.store'),
      { book_id: book.id },
      { preserveState: true, preserveScroll: true }
    );
    console.log('add user to waitng list for:', book.title);
    setIsModalOpen(false);
  };
  const handleAddToWishlist = () => {
    router.post(
      route('wishlists.store'),
      {
        book_id: book.id,
      },
      {
        preserveState: true,
        preserveScroll: true,
      }
    );
    setIsModalOpen(false);
  };

  return (
    <>
      <div className="bg-white shadow-sm border border-gray-200 rounded-lg p-4 flex justify-between items-center">
        <div>
          <div className="flex items-center mb-2">
            <h3 className="font-bold text-xl mr-4">{book.title}</h3>
            <p className="text-gray-700 text-sm">{book.author}</p>
          </div>
          <p className="text-gray-500 text-sm">ISBN: {book.isbn} </p>
        </div>
        {showFlash && flash.book_id === book.id && (
          <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div
              className={`px-4 py-3 rounded relative ${
                flash.type === 'success'
                  ? 'bg-green-100 border-green-400 text-green-700'
                  : 'bg-red-100 border-red-400 text-red-700'
              }`}
              role="alert"
            >
              <span className="block sm:inline">{flash.message}</span>
            </div>
          </div>
        )}
        <button
          onClick={() => setIsModalOpen(true)}
          className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4"
        >
          View Details
        </button>
      </div>
      {isModalOpen && (
        <BookCard
          book={book}
          loans={book.loans}
          onClose={() => setIsModalOpen(false)}
          onLoan={handleLoans}
          onWait={handleWaitList}
          onAddToWishlist={handleAddToWishlist}
          isAvailable={book.is_available}
          waitingListCount={book.waiting_list_count}
        />
      )}
    </>
  );
}
